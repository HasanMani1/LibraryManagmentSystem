<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist books (CATEGORY NAME ADDED)
$sql = "
    SELECT 
        w.wishlist_id,
        b.book_id,
        b.title,
        b.author,
        b.isbn,
        b.book_type,
        c.category_name
    FROM wishlist w
    JOIN book b ON w.book_id = b.book_id
    LEFT JOIN book_category c ON b.category_id = c.category_id
    WHERE w.user_id = ?
    ORDER BY w.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Wishlist</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* PAGE LAYOUT FOR FOOTER */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        /* Back button (unchanged) */
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

        .container {
            border: 2px solid #94a3b8;
        }
    </style>
</head>

<body class="bg-light">

<div class="main-content">

    <div class="container mt-5">
        <h2 class="text-center mb-4">
            <i class="bi bi-heart-fill text-danger"></i> My Wishlist
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
                    <td colspan="7">Your wishlist is empty.</td>
                </tr>
            <?php else: ?>
                <?php while ($b = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $b['book_id']; ?></td>
                        <td><?= htmlspecialchars($b['title']); ?></td>
                        <td><?= htmlspecialchars($b['author']); ?></td>
                        <td><?= htmlspecialchars($b['isbn']); ?></td>
                        <td><?= htmlspecialchars($b['book_type']); ?></td>
                        <td><?= htmlspecialchars($b['category_name'] ?? '—'); ?></td>
                        <td>
                            <a href="remove_from_wishlist.php?id=<?= $b['wishlist_id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Remove this book from your wishlist?');">
                                <i class="bi bi-trash"></i> Remove
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>
