<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch books (same logic as book.php)
$sql = "
    SELECT book_id, title, author, isbn, book_type, category_id
    FROM book
    WHERE title LIKE ? OR author LIKE ?
    ORDER BY title ASC
";

$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Books</h2>

    <!-- SEARCH (same as book.php) -->
    <form method="GET" class="d-flex mb-3">
        <input type="text"
               name="search"
               class="form-control me-2"
               placeholder="Search by title or author..."
               value="<?= htmlspecialchars($search); ?>">
        <button class="btn btn-primary">
            <i class="bi bi-search"></i> Search
        </button>
    </form>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Type</th>
                <th>Category</th>
                <th>Wishlist</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="7">No books found.</td>
            </tr>
        <?php else: ?>
            <?php while ($b = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $b['book_id']; ?></td>
                    <td><?= htmlspecialchars($b['title']); ?></td>
                    <td><?= htmlspecialchars($b['author']); ?></td>
                    <td><?= htmlspecialchars($b['isbn']); ?></td>
                    <td><?= htmlspecialchars($b['book_type']); ?></td>
                    <td><?= $b['category_id']; ?></td>
                    <td>
                        <form method="POST" action="add_to_wishlist.php" class="d-inline">
                            <input type="hidden" name="book_id" value="<?= $b['book_id']; ?>">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-heart"></i> Add
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
