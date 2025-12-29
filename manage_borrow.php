<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';
include 'notification_helper.php';

// 🔐 Admin only
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$success = "";

/* =========================
   APPROVE REQUEST
   ========================= */
if (isset($_POST['approve'])) {
    $borrow_id = intval($_POST['borrow_id']);

    // Lock row to avoid double approval
    $stmt = $conn->prepare("
        SELECT br.inventory_id, br.user_id, b.title
        FROM borrowing br
        JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
        JOIN book b ON bi.book_id = b.book_id
        WHERE br.borrowing_id = ? AND bi.is_available = 1
        LIMIT 1
    ");
    $stmt->bind_param("i", $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $inventory_id = $row['inventory_id'];
        $borrow_user  = $row['user_id'];
        $book_title   = $row['title'];

        $conn->begin_transaction();

        try {
            // Mark borrow approved
            $stmt = $conn->prepare(
                "UPDATE borrowing SET status_id = 1 WHERE borrowing_id = ?"
            );
            $stmt->bind_param("i", $borrow_id);
            $stmt->execute();

            // Mark copy unavailable
            $stmt = $conn->prepare(
                "UPDATE book_inventory SET is_available = 0 WHERE inventory_id = ?"
            );
            $stmt->bind_param("i", $inventory_id);
            $stmt->execute();

            createNotification(
                $borrow_user,
                "Borrow Request Approved",
                "Your request to borrow '{$book_title}' has been approved."
            );

            logActivity($_SESSION['user_id'], "Approved borrow ID: $borrow_id");

            $conn->commit();
            $success = "Borrow request approved.";
        } catch (Exception $e) {
            $conn->rollback();
        }
    }
}

/* =========================
   REJECT REQUEST
   ========================= */
if (isset($_POST['reject'])) {
    $borrow_id = intval($_POST['borrow_id']);

    $stmt = $conn->prepare("
        SELECT br.inventory_id, br.user_id, b.title
        FROM borrowing br
        JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
        JOIN book b ON bi.book_id = b.book_id
        WHERE br.borrowing_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $borrow_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        $stmt = $conn->prepare(
            "UPDATE borrowing SET status_id = 5 WHERE borrowing_id = ?"
        );
        $stmt->bind_param("i", $borrow_id);
        $stmt->execute();

        $stmt = $conn->prepare(
            "UPDATE book_inventory SET is_available = 1 WHERE inventory_id = ?"
        );
        $stmt->bind_param("i", $row['inventory_id']);
        $stmt->execute();

        createNotification(
            $row['user_id'],
            "Borrow Request Rejected",
            "Your request to borrow '{$row['title']}' was rejected."
        );

        logActivity($_SESSION['user_id'], "Rejected borrow ID: $borrow_id");
        $success = "Borrow request rejected.";
    }
}

/* =========================
   FETCH REQUESTS
   ========================= */
$search = trim($_GET['search'] ?? '');
$like = "%$search%";

$stmt = $conn->prepare("
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
");
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Borrow Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-attachment: fixed;
            padding-top: 120px;
        }

        .container {
            width: 95%;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
                border: 2px solid #94a3b8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #007bff;
            color: #fff;
        }

        .status-pending {
            color: orange;
        }

        .status-borrowed {
            color: blue;
        }

        .status-returned {
            color: green;
        }

        .status-overdue {
            color: red;
        }

        .status-rejected {
            color: gray;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .btn-approve {
            background: #28a745;
        }

        .btn-reject {
            background: #dc3545;
        }

        .alert-success {
            margin: 15px auto;
            width: 95%;
            padding: 10px;
            background: #d4edda;
            text-align: center;
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

        .back-btn i {
            font-size: 18px;
        }
    </style>
</head>

<body>

    <?php if ($success): ?>
        <div class="alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="container">
        <h2>📚 Manage Borrow Requests</h2>

        <form method="GET">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search user or book">
            <button class="btn btn-approve">Search</button>
        </form>

        <table>
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

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['borrowing_id'] ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?> (<?= htmlspecialchars($row['author']) ?>)</td>
                    <td><?= $row['copy_number'] ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['due_date'] ?></td>
                    <td><?= $row['returned_date'] ?: '—' ?></td>
                    <td>
                        <?php
                        echo match ($row['status_id']) {
                            1 => "<span class='status-borrowed'>Borrowed</span>",
                            2 => "<span class='status-returned'>Returned</span>",
                            3 => "<span class='status-overdue'>Overdue</span>",
                            4 => "<span class='status-pending'>Pending</span>",
                            5 => "<span class='status-rejected'>Rejected</span>",
                        };
                        ?>
                    </td>
                    <td>
                        <?php if ($row['status_id'] == 4): ?>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="borrow_id" value="<?= $row['borrowing_id'] ?>">
                                <button name="approve" class="btn btn-approve">Approve</button>
                            </form>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="borrow_id" value="<?= $row['borrowing_id'] ?>">
                                <button name="reject" class="btn btn-reject">Reject</button>
                            </form>
                            <?php else: ?>—<?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>