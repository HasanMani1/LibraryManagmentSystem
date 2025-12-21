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

$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id']; // 3 = Teacher, 4 = Student

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch books
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
<style>     .back-btn {
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
        }</style>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Books</h2>

    <!-- SEARCH -->
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="7">No books found.</td>
            </tr>
        <?php else: ?>
            <?php while ($b = $result->fetch_assoc()): ?>

                <?php
                // Wishlist check (Student + Teacher)
                $isWishlisted = false;
                if (in_array($role_id, [3, 4])) {
                    $w = $conn->prepare(
                        "SELECT wishlist_id FROM wishlist WHERE user_id = ? AND book_id = ?"
                    );
                    $w->bind_param("ii", $user_id, $b['book_id']);
                    $w->execute();
                    $w->store_result();
                    $isWishlisted = $w->num_rows > 0;
                    $w->close();
                }

                // Recommendation check (Teacher only)
                $isRecommended = false;
                if ($role_id == 3) {
                    $r = $conn->prepare(
                        "SELECT rec_id FROM recommendation WHERE suggested_by = ? AND book_id = ?"
                    );
                    $r->bind_param("ii", $user_id, $b['book_id']);
                    $r->execute();
                    $r->store_result();
                    $isRecommended = $r->num_rows > 0;
                    $r->close();
                }
                ?>

                <tr>
                    <td><?= $b['book_id']; ?></td>
                    <td><?= htmlspecialchars($b['title']); ?></td>
                    <td><?= htmlspecialchars($b['author']); ?></td>
                    <td><?= htmlspecialchars($b['isbn']); ?></td>
                    <td><?= htmlspecialchars($b['book_type']); ?></td>
                    <td><?= $b['category_id']; ?></td>
                    <td>

                        <!-- WISHLIST (Student + Teacher) -->
                        <?php if (in_array($role_id, [3, 4])): ?>
                            <?php if ($isWishlisted): ?>
                                <span class="text-success fw-semibold me-2">
                                    <i class="bi bi-check-circle-fill"></i> In Wishlist
                                </span>
                            <?php else: ?>
                                <form method="POST"
                                      action="add_to_wishlist.php"
                                      class="d-inline me-2"
                                      onsubmit="return confirm('Add this book to your wishlist?');">
                                    <input type="hidden" name="book_id" value="<?= $b['book_id']; ?>">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-heart"></i> Wishlist
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- RECOMMEND (Teacher only) -->
                        <?php if ($role_id == 3): ?>
                            <?php if ($isRecommended): ?>
                                <span class="text-success fw-semibold">
                                    <i class="bi bi-check-circle-fill"></i> Recommended
                                </span>
                            <?php else: ?>
                                <form method="POST" action="add_recommendation.php" class="d-inline">
                                    <input type="hidden" name="book_id" value="<?= $b['book_id']; ?>">
                                    <button class="btn btn-sm btn-outline-warning">
                                        ⭐ Recommend
                                    </button>
                                </form>
                            <?php endif; ?>
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
