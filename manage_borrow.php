<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$success = "";

// ----------------------
// APPROVE BORROW REQUEST
// ----------------------
if (isset($_POST['approve'])) {
    $borrow_id = intval($_POST['borrow_id']);

    // Get inventory ID
    $q = $conn->prepare("SELECT inventory_id FROM borrowing WHERE borrowing_id = ?");
    $q->bind_param("i", $borrow_id);
    $q->execute();
    $res = $q->get_result();

    if ($row = $res->fetch_assoc()) {
        $inventory_id = $row['inventory_id'];

        // Set status → Borrowed (1)
        $update = $conn->prepare("UPDATE borrowing SET status_id = 1 WHERE borrowing_id = ?");
        $update->bind_param("i", $borrow_id);
        $update->execute();

        // Mark copy unavailable
        $inv = $conn->prepare("UPDATE book_inventory SET is_available = 0 WHERE inventory_id = ?");
        $inv->bind_param("i", $inventory_id);
        $inv->execute();

        // Log
        logActivity($_SESSION['user_id'], "Approved borrow request ID: $borrow_id");

        $success = "Borrow request approved successfully!";
    }
}

// ----------------------
// REJECT BORROW REQUEST
// ----------------------
if (isset($_POST['reject'])) {
    $borrow_id = intval($_POST['borrow_id']);

    // Get inventory ID
    $q = $conn->prepare("SELECT inventory_id FROM borrowing WHERE borrowing_id = ?");
    $q->bind_param("i", $borrow_id);
    $q->execute();
    $res = $q->get_result();

    if ($row = $res->fetch_assoc()) {
        $inventory_id = $row['inventory_id'];

        // Set status → Rejected (5)
        $update = $conn->prepare("UPDATE borrowing SET status_id = 5 WHERE borrowing_id = ?");
        $update->bind_param("i", $borrow_id);
        $update->execute();

        // Make the copy available again
        $inv = $conn->prepare("UPDATE book_inventory SET is_available = 1 WHERE inventory_id = ?");
        $inv->bind_param("i", $inventory_id);
        $inv->execute();

        // Log
        logActivity($_SESSION['user_id'], "Rejected borrow request ID: $borrow_id");

        $success = "Borrow request rejected successfully!";
    }
}

// ----------------------
// SEARCH
// ----------------------
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "
SELECT 
    br.borrowing_id, 
    u.name AS user_name,
    b.title, 
    b.author, 
    bi.copy_number,
    br.borrow_date, 
    br.due_date, 
    br.returned_date, 
    br.status_id
FROM borrowing br
JOIN user u ON br.user_id = u.user_id
JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
JOIN book b ON bi.book_id = b.book_id
WHERE u.name LIKE ? OR b.title LIKE ?
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
<title>Manage Borrow Requests</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('images/saer.jpg');
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
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    input[type="text"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button, .btn {
        padding: 7px 12px;
        border-radius: 5px;
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-approve {
        background: linear-gradient(135deg, #28a745, #218838);
    }
    .btn-approve:hover {
        transform: scale(1.05);
        opacity: 0.85;
    }
    .btn-reject {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }
    .btn-reject:hover {
        transform: scale(1.05);
        opacity: 0.85;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #007bff;
        color: white;
    }
    tr:hover {
        background: #f2f2f2;
    }
    .alert-success {
        width: 95%;
        margin: auto;
        padding: 10px;
        background: #d4edda;
        color: #155724;
        border-radius: 6px;
        text-align: center;
    }
    .back-btn {
        position: fixed;
        top: 25px;
        left: 25px;
        padding: 10px 18px;
        border-radius: 50px;
        text-decoration: none;
        background: linear-gradient(135deg, #007bff, #00bfff);
        color: white;
        font-weight: bold;
    }
</style>
</head>

<body>


<?php if($success): ?>
    <div class="alert-success"><?= $success; ?></div>
<?php endif; ?>

<div class="container">
    <h2>📚 Manage Borrow Requests</h2>

    <form class="filter-bar" method="GET">
        <input type="text" name="search" placeholder="Search user or book..." value="<?= htmlspecialchars($search); ?>">
        <button class="btn btn-approve"><i class="bi bi-search"></i> Search</button>
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
            <th>Returned</th>
            <th>Status</th>
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
                <td><?= $row['returned_date'] ?: '---'; ?></td>

                <td>
                    <?php
                        if ($row['status_id'] == 4) echo "<span style='color:orange;'>Pending Approval</span>";
                        if ($row['status_id'] == 1) echo "<span style='color:blue;'>Borrowed</span>";
                        if ($row['status_id'] == 2) echo "<span style='color:green;'>Returned</span>";
                        if ($row['status_id'] == 3) echo "<span style='color:red;'>Overdue</span>";
                        if ($row['status_id'] == 5) echo "<span style='color:gray;'>Rejected</span>";
                    ?>
                </td>

                <td>
                    <?php if($row['status_id'] == 4): ?>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="borrow_id" value="<?= $row['borrowing_id']; ?>">
                            <button name="approve" class="btn btn-approve">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>
                        </form>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="borrow_id" value="<?= $row['borrowing_id']; ?>">
                            <button name="reject" class="btn btn-reject">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </form>
                    <?php else: ?>
                        ---
                    <?php endif; ?>
                </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
