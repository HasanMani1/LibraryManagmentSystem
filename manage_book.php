<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// 🔐 Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Handle delete (via GET for simplicity, can be converted to POST later)
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM book WHERE book_id = $delete_id");
    $conn->query("DELETE FROM book_inventory WHERE book_id = $delete_id");
    logActivity($_SESSION['user_id'], "Deleted book ID: $delete_id");
    header("Location: manage_books.php?deleted=1");
    exit;
}

// ✅ Search and filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_category = isset($_GET['filter_category']) ? intval($_GET['filter_category']) : 0;

// Fetch books with counts
$query = "
SELECT 
    b.book_id,
    b.title,
    b.author,
    b.isbn,
    b.book_type,
    b.category_id,
    (SELECT COUNT(*) FROM book_inventory WHERE book_id = b.book_id) AS total_copies,
    (SELECT COUNT(*) FROM book_inventory WHERE book_id = b.book_id AND is_available = 1) AS available_copies
FROM book b
WHERE (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)
";

if ($filter_category > 0) {
    $query .= " AND b.category_id = ?";
}

$query .= " ORDER BY b.book_id DESC";

$stmt = $conn->prepare($query);
$like = '%' . $search . '%';

if ($filter_category > 0) {
    $stmt->bind_param("sssi", $like, $like, $like, $filter_category);
} else {
    $stmt->bind_param("sss", $like, $like, $like);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch categories for filter dropdown
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
    <title>Manage Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
         body {
            font-family: Arial, sans-serif;
         
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding-top: 120px;
        }

      .container {
            width: 90%;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border: 2px solid #94a3b8;
        }

        h2 { text-align: center; margin-bottom: 25px; }

        .filter-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
            
        }

        input[type="text"], select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
                border: 2px solid #94a3b8;
        }

        button, .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-search { background: #007bff; }
        .btn-search:hover { background: #0056b3; transform: scale(1.05); }

        table { width: 100%; border-collapse: collapse; }
        th { background-color: #007bff; color: white; padding: 12px; }
        td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: #f2f2f2; }

        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; }
        .btn-edit:hover, .btn-delete:hover { transform: scale(1.05); opacity: 0.9; }

        .alert {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }

        .alert-success { background-color: #d4edda; color: #155724; }

        .add-btn {
            background: #28a745;
            padding: 10px 15px;
            margin-bottom: 15px;
            display: inline-block;
        }
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
        .back-btn i { font-size: 18px; }
    </style>
</head>
<body>



<div class="container">
    <h2>📚 Manage Books</h2>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Book deleted successfully!</div>
    <?php endif; ?>

    <!-- Search and Filter -->
    <form class="filter-bar" method="GET" action="">
        <input type="text" name="search" placeholder="Search by title, author or ISBN..." value="<?= htmlspecialchars($search); ?>">
        
        <select name="filter_category">
            <option value="0">All Categories</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c['category_id']; ?>" <?= ($filter_category == $c['category_id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($c['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-search"><i class="bi bi-search"></i> Search</button>
    </form>

    <a href="add_book.php" class="btn add-btn"><i class="bi bi-plus-circle"></i> Add New Book</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Type</th>
                <th>Category</th>
                <th>Total Copies</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="9">No books found.</td></tr>
        <?php else: ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['book_id']; ?></td>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['author']); ?></td>
                <td><?= $row['isbn']; ?></td>
                <td><?= htmlspecialchars($row['book_type']); ?></td>
                <td>
                    <?php
                        $cat_name = '';
                        foreach($categories as $cat) {
                            if ($cat['category_id'] == $row['category_id']) { $cat_name = $cat['category_name']; break; }
                        }
                        echo htmlspecialchars($cat_name ?: '—');
                    ?>
                </td>
                <td><?= $row['total_copies']; ?></td>
                <td style="font-weight:bold; color:blue;"><?= $row['available_copies']; ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['book_id']; ?>" class="btn btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                    <a href="manage_book.php?delete=<?= $row['book_id']; ?>" class="btn btn-delete"
                        onclick="return confirm('Delete this book and all its copies?');"><i class="bi bi-trash"></i> Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>