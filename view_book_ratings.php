<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// ✅ Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Fetch all book ratings and their averages
$query = " SELECT 
        b.book_id AS book_id,
        b.title AS book_title,
        AVG(r.rating_value) AS avg_rating,
        COUNT(*) AS total_reviews
    FROM book_rating r
    JOIN book b ON r.book_id = b.book_id
    GROUP BY b.book_id, b.title
    ORDER BY avg_rating DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book Ratings</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
         body {
            background-image: url('images/library-books.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        /* a few inline touches for layout */
        .rating-container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        section {
            background: transparent;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #024187;
            color: #fff;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn-view {
            background: #024187;
            color: #fff;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .stars {
            color: #FFD700;
            font-size: 18px;
        }
    </style>
</head>
<body>
<section>
    <div class="rating-container">
        <h2 style="color:#024187;">📚 View Book Ratings</h2>
        <p>See average ratings and reviews for each book.</p>
        <hr>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Book Title</th>
                    <th>Average Rating</th>
                    <th>Total Reviews</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['book_title']); ?></td>
                        <td>
                            <span class="stars">
                                <?= str_repeat('★', round($row['avg_rating'])); ?>
                                <?= str_repeat('☆', 5 - round($row['avg_rating'])); ?>
                            </span>
                            (<?= number_format($row['avg_rating'], 1); ?>)
                        </td>
                        <td><?= $row['total_reviews']; ?></td>
                        <td>
                            <a class="btn-view" href="view_book_comments.php?book_id=<?= $row['book_id']; ?>">View Comments</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No ratings found yet.</p>
        <?php endif; ?>
    </div>
</section>


</body>
</html>