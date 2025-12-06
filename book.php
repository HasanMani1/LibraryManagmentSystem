<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// ✅ Only logged-in users can view books
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// ----------------------
// FETCH BOOKS
// ----------------------
$sql = "
SELECT b.book_id, b.title, b.author, b.isbn, b.book_type, b.availability_status, b.category_id
FROM book b
WHERE b.title LIKE ? OR b.author LIKE ?
ORDER BY b.title ASC
";

$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();
$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Books List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
body { background-color: #f5f5f5; font-family: Arial, sans-serif; padding-top: 50px; }
.container { max-width: 1200px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
h1 { text-align: center; margin-bottom: 30px; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
th { background: #007bff; color: white; }
tr:hover { background: #f2f2f2; }
input[type="text"] { padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
button { padding: 7px 12px; border-radius: 5px; color: white; border: none; cursor: pointer; background: linear-gradient(135deg, #007bff, #00bfff); }
button:hover { opacity: 0.85; transform: scale(1.03); }
.back-btn { position: fixed; top: 20px; left: 20px; padding: 10px 18px; border-radius: 50px; text-decoration: none; background: linear-gradient(135deg, #007bff, #00bfff); color: white; font-weight: bold; }
</style>
</head>
<body>

<a href="admin_dashboard.php" class="back-btn"><i class="bi bi-arrow-left"></i> Back</a>

<div class="container">
<h1>📚 Books List</h1>

<form class="d-flex mb-3" method="GET">
    <input type="text" name="search" placeholder="Search by title or author..." class="form-control me-2" value="<?= htmlspecialchars($search); ?>">
    <button type="submit"><i class="bi bi-search"></i> Search</button>
</form>

<?php if (empty($books)): ?>
<p>No books found.</p>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Type</th>
            <th>Availability</th>
            <th>Category ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $b): ?>
        <tr>
            <td><?= $b['book_id']; ?></td>
            <td><?= htmlspecialchars($b['title']); ?></td>
            <td><?= htmlspecialchars($b['author']); ?></td>
            <td><?= htmlspecialchars($b['isbn']); ?></td>
            <td><?= htmlspecialchars($b['book_type']); ?></td>
            <td>
                <?php
                    if ($b['availability_status'] == 1) echo "<span style='color:green;'>Available</span>";
                    else echo "<span style='color:red;'>Not Available</span>";
                ?>
            </td>
            <td><?= $b['category_id']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</div>

</body>
</html>
