<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// ✅ Only logged-in users can access
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Handle Return
$success = "";
if (isset($_POST['return'])) {
    $borrow_id = intval($_POST['borrow_id']);

    // Get inventory_id
    $q = $conn->prepare("SELECT inventory_id FROM borrowing WHERE borrowing_id = ?");
    $q->bind_param("i", $borrow_id);
    $q->execute();
    $res = $q->get_result();
    if ($row = $res->fetch_assoc()) {
        $inventory_id = $row['inventory_id'];

        // Update borrowing status to Returned
        $update = $conn->prepare("UPDATE borrowing SET status_id = 2, returned_date = NOW() WHERE borrowing_id = ?");
        $update->bind_param("i", $borrow_id);
        $update->execute();

        // Make book available again
        $inv = $conn->prepare("UPDATE book_inventory SET is_available = 1 WHERE inventory_id = ?");
        $inv->bind_param("i", $inventory_id);
        $inv->execute();

        logActivity($_SESSION['user_id'], "Returned borrow ID: $borrow_id");
        $success = "✅ Book marked as returned successfully!";
    }
}

// ✅ Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "
SELECT br.borrowing_id, u.name AS user_name,
       b.title, b.author, bi.copy_number,
       br.borrow_date, br.due_date
FROM borrowing br
JOIN user u ON br.user_id = u.user_id
JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
JOIN book b ON bi.book_id = b.book_id
WHERE br.status_id = 1
AND (u.name LIKE ? OR b.title LIKE ?)
ORDER BY br.borrowing_id DESC
";
$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Return</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding-top: 120px;
        }
        .container {
            width: 95%;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border: 2px solid #94a3b8;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .filter-bar {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }
        input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
                border: 2px solid #94a3b8;
        }
        button, .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .btn-return {
            background: linear-gradient(135deg, #28a745, #218838);
        }
        .btn-return:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .alert {
            width: 95%;
            margin: 15px auto;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .back-btn {
            position: fixed;
            top: 25px;
            left: 25px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #0056b3, #0080ff);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            color: #f8f9fa;
            text-decoration: none;
        }
        .back-btn i { font-size: 18px; }
    </style>
</head>
<body>


<?php if($success): ?>
    <div class="alert alert-success"><?= $success; ?></div>
<?php endif; ?>

<div class="container">
    <h2>📚 Manage Returning Books</h2>

    <form class="filter-bar" method="GET">
        <input type="text" name="search" placeholder="Search by user or book..." value="<?= htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-return"><i class="bi bi-search"></i> Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Book</th>
                <th>Copy</th>
                <th>Borrowed</th>
                <th>Due</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['borrowing_id']; ?></td>
                <td><?= htmlspecialchars($row['user_name']); ?></td>
                <td><?= htmlspecialchars($row['title']); ?> (<?= htmlspecialchars($row['author']); ?>)</td>
                <td><?= $row['copy_number']; ?></td>
                <td><?= $row['borrow_date']; ?></td>
                <td><?= $row['due_date']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="borrow_id" value="<?= $row['borrowing_id']; ?>">
                        <button type="submit" name="return" class="btn btn-return"><i class="bi bi-check-circle"></i> Mark as Returned</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>