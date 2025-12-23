<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
// 🔐 Librarian only
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: unauthorized.php");
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$users = [];

if ($search !== '') {
    $stmt = $conn->prepare("
        SELECT user_id, name, email
        FROM user
        WHERE name LIKE ? OR email LIKE ? OR user_id = ?
        ORDER BY name
    ");
    $like = "%$search%";
    $id = is_numeric($search) ? intval($search) : 0;
    $stmt->bind_param("ssi", $like, $like, $id);
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Borrowers</title>
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
    <h2 class="text-center mb-4">🔍 Search Borrowers</h2>

    <form method="get" class="d-flex mb-4">
        <input type="text" name="search" class="form-control me-2"
               placeholder="Search by name, email, or ID"
               value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary">Search</button>
    </form>

    <?php if ($search !== ''): ?>
        <?php if (empty($users)): ?>
            <div class="alert alert-warning">No users found.</div>
        <?php else: ?>
            <table class="table table-bordered table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['user_id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <a href="librarian_user_borrowing.php?user_id=<?= $u['user_id'] ?>"
                               class="btn btn-sm btn-outline-info">
                                View Borrowing
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
