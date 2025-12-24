<?php
session_start();
require_once 'db_connect.php';

// ---------------------------
// Validate book ID
// ---------------------------
if (empty($_GET['book_id']) || !ctype_digit($_GET['book_id'])) {
    header("Location: books.php");
    exit;
}

$book_id = (int) $_GET['book_id'];

// ---------------------------
// Fetch book details
// ---------------------------
$sql = "
    SELECT 
        book_id,
        title,
        author,
        isbn,
        book_type,
        description,
        availability_status,
        category_id,
        cover_image,
        created_at
    FROM book
    WHERE book_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='container mt-5 alert alert-danger'>Book not found.</div>";
    exit;
}

$book = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .back-btn {
            position: fixed;
            top: 25px;
            left: 25px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: #fff;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 18px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,.2);
            transition: all .3s ease;
            z-index: 1000;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #0056b3, #0080ff);
            transform: scale(1.05);
            color: #f8f9fa;
        }

        .book-cover {
            max-width: 220px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
    </style>
</head>

<body class="bg-light">

<a href="book.php" class="back-btn">Back</a>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">

            <div class="row g-4">

                <!-- Book Cover -->
                <div class="col-md-4 text-center">
                    <?php if (!empty($book['cover_image']) && file_exists($book['cover_image'])): ?>
                        <img src="<?= htmlspecialchars($book['cover_image']) ?>"
                             alt="Book Cover"
                             class="book-cover img-fluid">
                    <?php else: ?>
                        <img src="assets/no-cover.png"
                             alt="No Cover Available"
                             class="book-cover img-fluid">
                    <?php endif; ?>
                </div>

                <!-- Book Details -->
                <div class="col-md-8">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>

                    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
                    <p><strong>Type:</strong> <?= htmlspecialchars($book['book_type']) ?></p>
                    <p><strong>Category ID:</strong> <?= (int) $book['category_id'] ?></p>
                    <p><strong>Added On:</strong> <?= htmlspecialchars($book['created_at']) ?></p>

                    <p>
                        <strong>Status:</strong>
                        <?php if ($book['availability_status'] === 'Available'): ?>
                            <span class="badge bg-success">Available</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Not Available</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <hr>

            <h5>Description</h5>
            <p class="text-muted">
                <?= nl2br(htmlspecialchars($book['description'] ?: 'No description available.')) ?>
            </p>

        </div>
    </div>
</div>

</body>
</html>
