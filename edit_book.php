<?php
session_start();
include 'db_connect.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Missing book ID.");
}

$book_id = intval($_GET['id']);
$success = "";
$error = "";

// Fetch book
$book = $conn->query("SELECT * FROM book WHERE book_id = $book_id")->fetch_assoc();
if (!$book) {
    die("Book not found.");
}

// Fetch categories
$categories = $conn->query("SELECT category_id, category_name FROM book_category");

// Count existing copies
$copyResult = $conn->query("
    SELECT COUNT(*) AS total 
    FROM book_inventory 
    WHERE book_id = $book_id
");
$currentCopies = $copyResult->fetch_assoc()['total'];

// Update book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $isbn        = trim($_POST['isbn']);
    $book_type   = trim($_POST['book_type']);
    $category_id = ($_POST['category_id'] !== "") ? intval($_POST['category_id']) : null;
    $availability = trim($_POST['availability_status']);
    $newCopies   = intval($_POST['copies']);

    if ($title === "") {
        $error = "Title cannot be empty.";
    } elseif ($newCopies < $currentCopies) {
        $error = "You cannot reduce the number of copies.";
    } else {

        // Update book details
        $stmt = $conn->prepare("
            UPDATE book SET 
                title=?, 
                author=?, 
                isbn=?, 
                book_type=?, 
                category_id=?, 
                availability_status=?
            WHERE book_id=?
        ");
        $stmt->bind_param(
            "ssssisi",
            $title,
            $author,
            $isbn,
            $book_type,
            $category_id,
            $availability,
            $book_id
        );

        if ($stmt->execute()) {

            // Add new copies if increased
            if ($newCopies > $currentCopies) {
                for ($i = $currentCopies + 1; $i <= $newCopies; $i++) {
                    $conn->query("
                        INSERT INTO book_inventory (book_id, copy_number, book_condition, is_available)
                        VALUES ($book_id, $i, 'Good', 1)
                    ");
                }
            }

            $success = "Book updated successfully!";
            $currentCopies = $newCopies;

        } else {
            $error = "Failed to update book.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Book</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}
.container {
    max-width: 600px;
    margin: 80px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #007bff;
}
input, select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
}
button {
    width: 100%;
    padding: 10px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
}
.alert-success {
    background: #d4edda;
    padding: 10px;
    margin-bottom: 15px;
    text-align: center;
}
.alert-error {
    background: #f8d7da;
    padding: 10px;
    margin-bottom: 15px;
    text-align: center;
}
.back-btn {
    position: fixed;
    top: 25px;
    left: 25px;
    background: #007bff;
    color: white;
    padding: 10px 18px;
    border-radius: 50px;
    text-decoration: none;
}
</style>
</head>
<body>

<a href="manage_book.php" class="back-btn">← Back</a>

<div class="container">
<h2>Edit Book</h2>

<?php if ($success): ?><div class="alert-success"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert-error"><?= $error ?></div><?php endif; ?>

<form method="POST">
    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

    <label>Author</label>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>">

    <label>ISBN</label>
    <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">

    <label>Book Type</label>
    <input type="text" name="book_type" value="<?= htmlspecialchars($book['book_type']) ?>">

    <label>Category</label>
    <select name="category_id">
        <option value="">-- Select Category --</option>
        <?php while ($c = $categories->fetch_assoc()): ?>
            <option value="<?= $c['category_id'] ?>"
                <?= ($book['category_id'] == $c['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['category_name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Availability Status</label>
    <select name="availability_status">
        <option value="Available" <?= $book['availability_status']=='Available'?'selected':'' ?>>Available</option>
        <option value="Unavailable" <?= $book['availability_status']=='Unavailable'?'selected':'' ?>>Unavailable</option>
    </select>

    <label>Total Copies</label>
    <input type="number" name="copies" min="<?= $currentCopies ?>" value="<?= $currentCopies ?>" required>

    <button type="submit">Save Changes</button>
</form>
</div>

</body>
</html>
