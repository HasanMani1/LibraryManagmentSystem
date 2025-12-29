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

if (!isset($_GET['id'])) {
    die("Missing book ID.");
}

$book_id = (int) $_GET['id'];
$success = "";
$error   = "";

// ----------------------
// FETCH BOOK
// ----------------------
$stmt = $conn->prepare("SELECT * FROM book WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    die("Book not found.");
}

// ----------------------
// FETCH CATEGORIES
// ----------------------
$categories = $conn->query(
    "SELECT category_id, category_name FROM book_category ORDER BY category_name"
);

// ----------------------
// COUNT EXISTING COPIES
// ----------------------
$res = $conn->query("
    SELECT COUNT(*) AS total 
    FROM book_inventory 
    WHERE book_id = $book_id
");
$currentCopies = (int)$res->fetch_assoc()['total'];

// ----------------------
// UPDATE BOOK
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $isbn        = trim($_POST['isbn']);
    $book_type   = $_POST['book_type'] ?? '';
    $description = trim($_POST['description']);
    $category_id = (int)$_POST['category_id'];
    $newCopies   = (int)$_POST['copies'];

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
    } elseif ($newCopies < $currentCopies) {
        $error = "You cannot reduce the number of copies.";
    } else {

        // ----------------------
        // ISBN UNIQUENESS (EXCEPT SELF)
        // ----------------------
        $chk = $conn->prepare("
            SELECT book_id FROM book 
            WHERE isbn = ? AND book_id != ?
        ");
        $chk->bind_param("si", $isbn, $book_id);
        $chk->execute();
        $chk->store_result();

        if ($chk->num_rows > 0) {
            $error = "Another book already uses this ISBN.";
        } else {

            // ----------------------
            // IMAGE UPLOAD (JFIF FIX)
            // ----------------------
            $imagePath = $book['cover_image'];

            if (!empty($_FILES['cover_image']['name'])) {

                $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'jfif'];

                if (!in_array($ext, $allowedExt)) {
                    $error = "Only JPG and PNG images are allowed.";
                } else {

                    // Normalize jfif to jpg
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
                $availability = ($newCopies > 0) ? 'Available' : 'Not Available';

                // ----------------------
                // UPDATE BOOK
                // ----------------------
                $upd = $conn->prepare("
                    UPDATE book SET
                        title = ?,
                        author = ?,
                        isbn = ?,
                        book_type = ?,
                        description = ?,
                        cover_image = ?,
                        category_id = ?,
                        availability_status = ?
                    WHERE book_id = ?
                ");

                $upd->bind_param(
                    "ssssssisi",
                    $title,
                    $author,
                    $isbn,
                    $book_type,
                    $description,
                    $imagePath,
                    $category_id,
                    $availability,
                    $book_id
                );

                if ($upd->execute()) {

                    // ----------------------
                    // ADD NEW COPIES
                    // ----------------------
                    if ($newCopies > $currentCopies) {
                        for ($i = $currentCopies + 1; $i <= $newCopies; $i++) {
                            $conn->query("
                                INSERT INTO book_inventory
                                (book_id, copy_number, book_condition, is_available)
                                VALUES ($book_id, $i, 'Good', 1)
                            ");
                        }
                    }

                    $success = "Book updated successfully.";
                    $currentCopies = $newCopies;
                } else {
                    $error = "Failed to update book.";
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
    <title>Edit Book</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .container {
            max-width: 650px;
            margin: 80px auto;
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
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
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

        <form method="POST" enctype="multipart/form-data">

            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

            <label>Author</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

            <label>ISBN</label>
            <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>

            <label>Book Type</label>
            <select name="book_type" required>
                <option value="Ebook" <?= $book['book_type'] === 'Ebook' ? 'selected' : '' ?>>Ebook</option>
                <option value="Hardcopy" <?= $book['book_type'] === 'Hardcopy' ? 'selected' : '' ?>>Hardcopy</option>
            </select>

            <label>Category</label>
            <select name="category_id" required>
                <?php while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['category_id'] ?>"
                        <?= $book['category_id'] == $c['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['category_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Description</label>
            <textarea name="description" rows="4" required><?= htmlspecialchars($book['description']) ?></textarea>

            <label>Cover Image (optional)</label>
            <input type="file" name="cover_image" accept="image/*">

            <label>Total Copies</label>
            <input type="number" name="copies" min="<?= $currentCopies ?>" value="<?= $currentCopies ?>" required>

            <button type="submit">Save Changes</button>

        </form>
    </div>

</body>

</html>