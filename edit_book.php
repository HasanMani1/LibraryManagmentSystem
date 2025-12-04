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

// Fetch book info
$book = $conn->query("SELECT * FROM book WHERE book_id = $book_id")->fetch_assoc();
if (!$book) die("Book not found.");

// Fetch categories
$categories_result = $conn->query("SELECT category_id, category_name FROM book_category");
$categories = [];
while ($c = $categories_result->fetch_assoc()) {
    $categories[] = $c;
}

// Update book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $book_type = trim($_POST['book_type']);
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== "" ? intval($_POST['category_id']) : null;
    $availability = trim($_POST['availability_status']);

    if ($title === "") {
        $error = "Title cannot be empty.";
    } else {
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
        $stmt->bind_param("ssssisi", $title, $author, $isbn, $book_type, $category_id, $availability, $book_id);

        if ($stmt->execute()) {
            $success = "Book updated successfully!";
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
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 80px auto 0 auto; /* pushes container down */
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

    input[type="text"], input[type="number"], select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        transition: 0.2s ease;
    }

    button:hover {
        background: #218838;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        text-align: center;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        text-align: center;
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

<a href="manage_book.php" class="back-btn"><i class="bi bi-arrow-left"></i> Back</a>


<div class="container">
    <h2>✏️ Edit Book</h2>

    <?php if ($success): ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']); ?>" required>

        <label>Author</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']); ?>">

        <label>ISBN</label>
        <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']); ?>">

        <label>Book Type</label>
        <input type="text" name="book_type" value="<?= htmlspecialchars($book['book_type']); ?>">

        <label>Category</label>
        <select name="category_id">
            <option value="">-- Select Category (Optional) --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['category_id']; ?>" <?= ($book['category_id'] == $c['category_id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($c['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Availability Status</label>
        <select name="availability_status">
            <option value="Available" <?= $book['availability_status'] === 'Available' ? 'selected' : ''; ?>>Available</option>
            <option value="Unavailable" <?= $book['availability_status'] === 'Unavailable' ? 'selected' : ''; ?>>Unavailable</option>
        </select>

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>