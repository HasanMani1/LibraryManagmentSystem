<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

// 🔐 Allow only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 📜 Fetch borrow history
$stmt = $conn->prepare("
    SELECT 
        b.title,
        b.author,
        br.borrow_date,
        br.due_date,
        br.returned_date,
        s.status_name
    FROM borrowing br
    INNER JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
    INNER JOIN book b ON bi.book_id = b.book_id
    INNER JOIN borrowing_status s ON br.status_id = s.status_id
    WHERE br.user_id = ?
    ORDER BY br.borrow_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Borrow History</title>

    <style>
        body {
            font-family: Arial, sans-serif;
    
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding-top: 120px;

            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        .container {
            width: 95%;
            max-width: 950px;
            margin: 80px auto 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
              border: 2px solid #94a3b8;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007bff;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .status {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }

        .Pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .Approved {
            background-color: #d4edda;
            color: #155724;
        }

        .Borrowed {
            background-color: #cce5ff;
            color: #004085;
        }

        .Returned {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .Rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .no-records {
            text-align: center;
            font-weight: bold;
            padding: 20px;
            color: #666;
        }

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
            border-radius: 50px;
            padding: 10px 18px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>

<body>

    <div class="main-content">
        <div class="container">
            <h1>📚 My Borrow History</h1>

            <table>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Returned Date</th>
                    <th>Status</th>
                </tr>

                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="6" class="no-records">No borrow history found.</td>
                    </tr>
                <?php else: ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= date('Y-m-d', strtotime($row['borrow_date'])) ?></td>
                            <td><?= date('Y-m-d', strtotime($row['due_date'])) ?></td>
                            <td><?= $row['returned_date'] ? date('Y-m-d', strtotime($row['returned_date'])) : '—' ?></td>
                            <td>
                                <span class="status <?= htmlspecialchars($row['status_name']) ?>">
                                    <?= htmlspecialchars($row['status_name']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>



</body>

</html>