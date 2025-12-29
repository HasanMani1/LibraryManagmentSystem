<?php
session_start();
require_once 'db_connect.php';
require_once 'back_button.php';
require_once 'log_activity.php';

/* 🔐 Auth check */
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id']; // 3 = Teacher, 4 = Student

$search = trim($_GET['search'] ?? '');
$filter_category = (int)($_GET['filter_category'] ?? 0);

/* 🔍 Fetch books */
$sql = "
    SELECT 
        book_id,
        title,
        author,
        isbn,
        book_type,
        availability_status,
        category_id
    FROM book
    WHERE (title LIKE ? OR author LIKE ?)
";

if ($filter_category > 0) {
    $sql .= " AND category_id = ?";
}

$sql .= " ORDER BY title ASC";

$stmt = $conn->prepare($sql);
$like = "%$search%";

if ($filter_category > 0) {
    $stmt->bind_param("ssi", $like, $like, $filter_category);
} else {
    $stmt->bind_param("ss", $like, $like);
}

$stmt->execute();
$result = $stmt->get_result();

/* 📂 Fetch categories (LIKE manage_books.php) */
$categories_result = $conn->query("SELECT category_id, category_name FROM book_category");
$categories = [];
while ($c = $categories_result->fetch_assoc()) {
    $categories[] = $c;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Books</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 120px;
            background-color: #f8f9fa;
        }

        .container {
            border: 2px solid #94a3b8;
            border-radius: 10px;
            padding: 20px;
            background: white;
        }

        .form-control {
            border: 2px solid #94a3b8;
        }

        .action-btn {
            border: 1.8px solid #024187;
            color: #024187;
            background: transparent;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease-in-out;
        }

        .action-btn:hover {
            background: #024187;
            color: #fff;
            transform: translateY(-1px);
        }

        .action-btn.disabled {
            background: #facc15;
            border-color: #facc15;
            color: #1f2933;
            pointer-events: none;
        }
        /*  BACK BUTTON  */
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
</head>

<body>

    <main>
        <div class="container mt-5">
            <h2 class="text-center mb-4">📚 Books</h2>

            <!-- SEARCH + CATEGORY -->
            <form method="get" class="d-flex mb-3 gap-2">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search title or author"
                    value="<?= htmlspecialchars($search) ?>">

                <select name="filter_category" class="form-control" style="max-width:220px;">
                    <option value="0">All Categories</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['category_id'] ?>"
                            <?= $filter_category == $c['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </form>

            <!-- TABLE -->
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th style="min-width:220px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result->num_rows === 0): ?>
                        <tr>
                            <td colspan="7">No books found.</td>
                        </tr>
                    <?php endif; ?>

                    <?php while ($b = $result->fetch_assoc()): ?>

                        <?php
                        /* ❤️ Wishlist */
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

                        /* ⭐ Recommendation */
                        $isRecommended = false;
                        if ($role_id == 3) {
                            $r = $conn->prepare(
                                "SELECT rec_id FROM recommendation WHERE book_id = ? AND suggested_by = ? LIMIT 1"
                            );
                            $r->bind_param("ii", $b['book_id'], $user_id);
                            $r->execute();
                            $r->store_result();
                            $isRecommended = $r->num_rows > 0;
                            $r->close();
                        }

                        /* 📂 Category name (LIKE manage_books.php) */
                        $cat_name = '—';
                        foreach ($categories as $cat) {
                            if ($cat['category_id'] == $b['category_id']) {
                                $cat_name = $cat['category_name'];
                                break;
                            }
                        }
                        ?>

                        <tr>
                            <td>
                                <a href="detail.php?book_id=<?= $b['book_id'] ?>"
                                    class="fw-semibold text-decoration-none">
                                    <?= htmlspecialchars($b['title']) ?>
                                </a>
                            </td>

                            <td><?= htmlspecialchars($b['author']) ?></td>
                            <td><?= htmlspecialchars($b['isbn']) ?></td>

                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars($b['book_type']) ?></span>
                            </td>

                            <td><?= htmlspecialchars($cat_name) ?></td>

                            <td>
                                <?php if ($b['availability_status'] === 'Available'): ?>
                                    <span class="badge bg-success">Available</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Unavailable</span>
                                <?php endif; ?>
                            </td>

                            <!-- ACTIONS -->
                            <td>

                                <?php if (in_array($role_id, [3, 4]) && $b['availability_status'] === 'Available'): ?>
                                    <?php if ($isWishlisted): ?>
                                        <span class="text-success fw-semibold me-2">
                                            <i class="bi bi-check-circle-fill"></i> Wishlisted
                                        </span>
                                    <?php else: ?>
                                        <form method="post" action="add_to_wishlist.php" class="d-inline me-1">
                                            <input type="hidden" name="book_id" value="<?= $b['book_id'] ?>">
                                            <button class="action-btn">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($role_id == 3): ?>
                                    <?php if ($isRecommended): ?>
                                        <span class="action-btn disabled">
                                            <i class="bi bi-star-fill"></i> Recommended
                                        </span>
                                    <?php else: ?>
                                        <form method="post" action="recommend_book.php" class="d-inline me-1">
                                            <input type="hidden" name="book_id" value="<?= $b['book_id'] ?>">
                                            <button class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-star-fill"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- 📚 Borrow (Hardcopy + Ebook) -->
                                <?php if (
                                    in_array($role_id, [3, 4]) &&
                                    $b['availability_status'] === 'Available'
                                ): ?>
                                    <a href="borrow_book.php?book_id=<?= $b['book_id'] ?>"
                                        class="action-btn"
                                        onclick="return confirm('Borrow this book?');">
                                        <i class="bi bi-journal-arrow-up"></i>
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>