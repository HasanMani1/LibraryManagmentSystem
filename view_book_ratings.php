<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// ✅ Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Fetch all book ratings and their averages
$query = "
    SELECT 
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
    <title>View Book Ratings</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-size: cover;
            background-attachment: fixed;
            margin: 0;

            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        .rating-container {
            width: 80%;
            margin: 80px auto;
            background: white;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
               border: 2px solid #94a3b8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
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

        .stars {
            color: #ffda09ff;
            font-size: 18px;
        }

        .btn-view {
            background: #024187;
            color: #fff;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

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

     
    </style>
</head>

<body>

    <div class="main-content">
        <div class="rating-container">
            <h2 style="color:#024187;">📚 View Book Ratings</h2>
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
                                <a class="btn-view" href="view_book_comment.php?book_id=<?= $row['book_id']; ?>">
                                    View Comments
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No ratings found yet.</p>
            <?php endif; ?>
        </div>
    </div>



</body>

</html>