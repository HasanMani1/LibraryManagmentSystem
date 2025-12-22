<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

// 🔐 Only Student allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 4) {
    header("Location: unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch recommended books
$stmt = $conn->prepare("SELECT 
        r.rec_id,
        b.book_id,
        b.title,
        b.author,
        b.isbn,
        u.name AS teacher_name FROM recommendation r
    JOIN book b ON r.book_id = b.book_id
    JOIN user u ON r.suggested_by = u.user_id
    WHERE r.display_on_dashboard = 1
    ORDER BY r.rec_id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recommended Books</title>
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
</style>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">
        📖 Recommended Books
    </h2>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Recommended By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="5">No book recommendations available.</td>
            </tr>
        <?php else: ?>
            <?php while ($r = $result->fetch_assoc()): ?>

                <?php
                // Check wishlist status
                $w = $conn->prepare(
                    "SELECT wishlist_id FROM wishlist WHERE user_id = ? AND book_id = ?"
                );
                $w->bind_param("ii", $user_id, $r['book_id']);
                $w->execute();
                $w->store_result();
                $isWishlisted = $w->num_rows > 0;
                $w->close();
                ?>

                <tr>
                    <td><?= htmlspecialchars($r['title']); ?></td>
                    <td><?= htmlspecialchars($r['author']); ?></td>
                    <td><?= htmlspecialchars($r['isbn']); ?></td>
                    <td><?= htmlspecialchars($r['teacher_name']); ?></td>
                    <td>

                        <!-- Wishlist -->
                        <?php if ($isWishlisted): ?>
                            <span class="text-success fw-semibold me-2">
                                <i class="bi bi-check-circle-fill"></i> In Wishlist
                            </span>
                        <?php else: ?>
                            <form method="POST"
                                  action="add_to_wishlist.php"
                                  class="d-inline me-2"
                                  onsubmit="return confirm('Add this book to your wishlist?');">
                                <input type="hidden" name="book_id" value="<?= $r['book_id']; ?>">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-heart"></i> Wishlist
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Borrow -->
                        <a href="borrow_book.php" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-book"></i> Borrow
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
