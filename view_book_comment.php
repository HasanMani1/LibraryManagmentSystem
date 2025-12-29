<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// Get the book ID
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;
if ($book_id <= 0) {
    die("Invalid book ID");
}

// Fetch book info
$stmt = $conn->prepare("SELECT title FROM book WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book_result = $stmt->get_result();
if ($book_result->num_rows === 0) {
    die("Book not found");
}
$book = $book_result->fetch_assoc();

// Fetch all ratings/comments for this book
$stmt = $conn->prepare("
    SELECT r.rating_value, r.comment, u.name AS reviewer_name, r.created_at
    FROM book_rating r
    LEFT JOIN user u ON r.user_id = u.user_id
    WHERE r.book_id = ?
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$comments_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Comments - <?= htmlspecialchars($book['title']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body {
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
    padding-top: 50px;
}
.container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
           border: 2px solid #94a3b8;
}
h2 { text-align: center; margin-bottom: 20px; color: #024187; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
th { background: #024187; color: #fff; }
tr:hover { background-color: #f9f9f9; }
.stars { color: #FFD700; font-size: 16px; }

        .back-btn {
            position: fixed;
            top: 25px;
            left: 25px;
            padding: 10px 18px;
            border-radius: 50px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: bold;
            text-decoration: none;
            z-index: 1000;
        }
.back-btn:hover { background: #0056b3; }
</style>
</head>
<body>

<div class="container">

    <h2>📖 Comments for "<?= htmlspecialchars($book['title']); ?>"</h2>

    <?php if ($comments_result->num_rows === 0): ?>
        <p>No comments for this book yet.</p>
    <?php else: ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $comments_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['reviewer_name'] ?: 'Anonymous'); ?></td>
                        <td>
                            <span class="stars">
                                <?= str_repeat('★', round($row['rating_value'])); ?>
                                <?= str_repeat('☆', 5 - round($row['rating_value'])); ?>
                            </span>
                            (<?= number_format($row['rating_value'],1); ?>)
                        </td>
                        <td><?= htmlspecialchars($row['comment']); ?></td>
                        <td><?= date("d M Y", strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
