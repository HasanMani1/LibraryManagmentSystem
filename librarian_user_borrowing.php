<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
// 🔐 Librarian only
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: unauthorized.php");
    exit;
}

$user_id = intval($_GET['user_id']);
if (!$user_id) {
    header("Location: librarian_user_search.php");
    exit;
}

// Fetch user info
$stmt = $conn->prepare("SELECT name, email FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch borrowing history
$stmt = $conn->prepare("
    SELECT 
        b.title,
        br.borrow_date,
        br.due_date,
        br.returned_date,
        br.status_id
    FROM borrowing br
    JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
    JOIN book b ON bi.book_id = b.book_id
    WHERE br.user_id = ?
    ORDER BY br.borrow_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$records = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Borrowing History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
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
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-3">📚 Borrowing History</h2>

    <p>
        <strong>User:</strong> <?= htmlspecialchars($user['name']) ?><br>
        <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
    </p>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Returned Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($records->num_rows === 0): ?>
            <tr>
                <td colspan="5">No borrowing records.</td>
            </tr>
        <?php else: ?>
            <?php while ($r = $records->fetch_assoc()): ?>
                <?php
                $isOverdue = !$r['returned_date'] && strtotime($r['due_date']) < strtotime(date('Y-m-d'));
                ?>
                <tr class="<?= $isOverdue ? 'table-danger' : '' ?>">
                    <td><?= htmlspecialchars($r['title']) ?></td>
                    <td><?= $r['borrow_date'] ?></td>
                    <td><?= $r['due_date'] ?></td>
                    <td><?= $r['returned_date'] ?? '—' ?></td>
                    <td>
                        <?php if ($isOverdue): ?>
                            ⚠️ Overdue
                        <?php elseif ($r['returned_date']): ?>
                            Returned
                        <?php else: ?>
                            Borrowed
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
