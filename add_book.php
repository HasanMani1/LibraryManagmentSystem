<?php
session_start();
include 'db_connect.php';

// ----------------------
// AUTH CHECK
// ----------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$success = "";
$error   = "";

// ----------------------
// LOAD CATEGORIES
// ----------------------
$categories = $conn->query(
    "SELECT category_id, category_name FROM book_category"
);

// ----------------------
// ADD BOOK
// ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $isbn        = trim($_POST['isbn']);
    $book_type   = $_POST['book_type'] ?? '';
    $category_id = ($_POST['category_id'] !== '') ? intval($_POST['category_id']) : null;
    $copies      = intval($_POST['copies']);

    // ----------------------
    // VALIDATION
    // ----------------------
    $allowedTypes = ['Ebook', 'Hardcopy'];

    if ($title === '') {
        $error = "Title is required.";
    } elseif (!in_array($book_type, $allowedTypes)) {
        $error = "Invalid book type selected.";
    } elseif ($copies < 1) {
        $error = "At least one copy is required.";
    } else {

        // ----------------------
        // INSERT BOOK
        // ----------------------
        $stmt = $conn->prepare("
            INSERT INTO book 
                (title, author, isbn, book_type, category_id, availability_status, created_at)
            VALUES 
                (?, ?, ?, ?, ?, 'Available', NOW())
        ");

        $stmt->bind_param(
            "ssssi",
            $title,
            $author,
            $isbn,
            $book_type,
            $category_id
        );

        if ($stmt->execute()) {

            $book_id = $conn->insert_id;

            // ----------------------
            // INSERT INVENTORY COPIES
            // ----------------------
            for ($i = 1; $i <= $copies; $i++) {
                $conn->query("
                    INSERT INTO book_inventory 
                        (book_id, copy_number, book_condition, is_available)
                    VALUES 
                        ($book_id, $i, 'Good', 1)
                ");
            }

            $success = "Book added successfully!";
        } else {
            $error = "Failed to add book.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>

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
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
        }

        input,
        select {
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
        <h2>Add New Book</h2>

        <?php if ($success): ?>
            <div class="alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Author</label>
            <input type="text" name="author">

            <label>ISBN</label>
            <input type="text" name="isbn">

            <label>Book Type</label>
            <select name="book_type" required>
                <option value="">-- Select Book Type --</option>
                <option value="Ebook">Ebook</option>
                <option value="Hardcopy">Hardcopy</option>
            </select>

            <label>Category</label>
            <select name="category_id">
                <option value="">-- Select Category (Optional) --</option>
                <?php while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['category_id'] ?>">
                        <?= htmlspecialchars($c['category_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Number of Copies</label>
            <input type="number" name="copies" min="1" required>

            <button type="submit">Add Book</button>

        </form>
    </div>

</body>

</html>