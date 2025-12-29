<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// 🔐 Only Teacher allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: unauthorized.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];

// Fetch recommendations by this teacher
$stmt = $conn->prepare("
    SELECT 
        r.rec_id,
        b.book_id,
        b.title,
        b.author,
        b.isbn,
        b.book_type,
        b.category_id
    FROM recommendation r
    JOIN book b ON r.book_id = b.book_id
    WHERE r.suggested_by = ?
    ORDER BY r.rec_id DESC
");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recommendations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        .container{
              border: 2px solid #94a3b8;
        }
</style>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">
        ⭐ My Book Recommendations
    </h2>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Type</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="7">You have not recommended any books yet.</td>
            </tr>
        <?php else: ?>
            <?php while ($r = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['book_id']; ?></td>
                    <td><?= htmlspecialchars($r['title']); ?></td>
                    <td><?= htmlspecialchars($r['author']); ?></td>
                    <td><?= htmlspecialchars($r['isbn']); ?></td>
                    <td><?= htmlspecialchars($r['book_type']); ?></td>
                    <td><?= $r['category_id']; ?></td>
                    <td>
                        <a href="remove_recommendation.php?id=<?= $r['rec_id']; ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Remove this recommendation?');">
                            <i class="bi bi-trash"></i> Remove
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>

        </tbody>
    </table>
</div>

</body>
</html>
