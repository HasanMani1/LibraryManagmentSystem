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
    "SELECT category_id, category_name FROM book_category ORDER BY category_name"
);

// ----------------------
// ADD BOOK
// ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $isbn        = trim($_POST['isbn']);
    $book_type   = $_POST['book_type'] ?? '';
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category_id']);
    $copies      = intval($_POST['copies']);

    $allowedTypes = ['Ebook', 'Hardcopy'];

    // ----------------------
    // VALIDATION
    // ----------------------
    if ($title === '' || $author === '' || $isbn === '' || $description === '') {
        $error = "All fields are required.";
    } elseif (!in_array($book_type, $allowedTypes)) {
        $error = "Invalid book type.";
    } elseif ($category_id < 1) {
        $error = "Category is required.";
    } elseif ($copies < 1) {
        $error = "At least one copy is required.";
    } else {

        // ----------------------
        // ISBN UNIQUENESS
        // ----------------------
        $check = $conn->prepare("SELECT book_id FROM book WHERE isbn = ?");
        $check->bind_param("s", $isbn);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "A book with this ISBN already exists.";
        } else {

            // ----------------------
            // IMAGE UPLOAD 
            // ----------------------
            $imagePath = null;

            if (!empty($_FILES['cover_image']['name'])) {

                $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'jfif'];

                if (!in_array($ext, $allowedExt)) {
                    $error = "Only JPG and PNG images are allowed.";
                } else {

                    // Convert jfif to jpg
                    if ($ext === 'jfif') {
                        $ext = 'jpg';
                    }

                    if (!is_dir("uploads/books")) {
                        mkdir("uploads/books", 0777, true);
                    }

                    $imagePath = "uploads/books/" . uniqid() . "." . $ext;
                    move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath);
                }
            }

            if ($error === "") {

                // ----------------------
                // AUTO AVAILABILITY
                // ----------------------
                $availability = ($copies > 0) ? 'Available' : 'Not Available';

                // ----------------------
                // INSERT BOOK
                // ----------------------
                $stmt = $conn->prepare("
                    INSERT INTO book 
                        (title, author, isbn, book_type, description, cover_image, category_id, availability_status, created_at)
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");

                $stmt->bind_param(
                    "ssssssis",
                    $title,
                    $author,
                    $isbn,
                    $book_type,
                    $description,
                    $imagePath,
                    $category_id,
                    $availability
                );

                if ($stmt->execute()) {

                    $book_id = $conn->insert_id;

                    // ----------------------
                    // INVENTORY COPIES
                    // ----------------------
                    for ($i = 1; $i <= $copies; $i++) {
                        $conn->query("
                            INSERT INTO book_inventory 
                                (book_id, copy_number, book_condition, is_available)
                            VALUES 
                                ($book_id, $i, 'Good', 1)
                        ");
                    }

                    $success = "Book added successfully.";
                } else {
                    $error = "Failed to save book.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Book</title>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 650px;
            margin: 70px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            border: 2px solid #94a3b8;
        }

        label {
            font-weight: 600;
            margin-top: 12px;
            display: block;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            width: 100%;
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
            color: #fff;
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

        <form method="POST" enctype="multipart/form-data">

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Author</label>
            <input type="text" name="author" required>

            <label>ISBN</label>
            <input type="text" name="isbn" required>

            <label>Book Type</label>
            <select name="book_type" required>
                <option value="">-- Select Book Type --</option>
                <option value="Ebook">Ebook</option>
                <option value="Hardcopy">Hardcopy</option>
            </select>

            <label>Category</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['category_id'] ?>">
                        <?= htmlspecialchars($c['category_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Description</label>
            <textarea name="description" rows="4" required></textarea>

            <label>Cover Image</label>
            <input type="file" name="cover_image" accept="image/*">

            <label>Number of Copies</label>
            <input type="number" name="copies" min="1" required>

            <button type="submit">Add Book</button>

        </form>
    </div>

</body>

</html>