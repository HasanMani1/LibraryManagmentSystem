<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

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
// HANDLE FORM SUBMISSION
// ----------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $donor_id    = $_SESSION['user_id'];
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
        // ISBN DUPLICATE CHECK
        // ----------------------
        $check = $conn->prepare("
            SELECT donation_id 
            FROM book_donation 
            WHERE isbn = ?
        ");
        $check->bind_param("s", $isbn);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "This ISBN has already been donated.";
        } else {

            // ----------------------
            // IMAGE UPLOAD (JFIF FIX)
            // ----------------------
            $imagePath = null;

            if (!empty($_FILES['cover_image']['name'])) {

                $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'jfif'];

                if (!in_array($ext, $allowedExt)) {
                    $error = "Only JPG and PNG images are allowed.";
                } else {

                    if ($ext === 'jfif') {
                        $ext = 'jpg';
                    }

                    if (!is_dir("uploads/donations")) {
                        mkdir("uploads/donations", 0777, true);
                    }

                    $imagePath = "uploads/donations/" . uniqid() . "." . $ext;
                    move_uploaded_file($_FILES['cover_image']['tmp_name'], $imagePath);
                }
            }

            if ($error === "") {

                // ----------------------
                // INSERT DONATION
                // ----------------------
                $stmt = $conn->prepare("
                    INSERT INTO book_donation
                        (donor_id, book_title, author, isbn, book_type, description, cover_image, category_id, copies, status, is_approved, created_at)
                    VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 0, NOW())
                ");

                $stmt->bind_param(
                    "issssssii",
                    $donor_id,
                    $title,
                    $author,
                    $isbn,
                    $book_type,
                    $description,
                    $imagePath,
                    $category_id,
                    $copies
                );

                if ($stmt->execute()) {
                    $success = "Book donation submitted successfully. Awaiting admin approval.";
                } else {
                    $error = "Failed to submit donation.";
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
    <title>Donate a Book</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        .container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            border: 2px solid #94a3b8;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 2px solid #94a3b8;
        }

        textarea {
            resize: vertical;
        }

        button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
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
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: #fff;
            padding: 10px 18px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
        }
    </style
    </style>
</head>

<body>

    <div class="main-content">
        <div class="container">

            <h2>📖 Donate a Book</h2>

            <?php if ($success): ?><div class="alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

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

                <button type="submit">Submit Donation</button>

            </form>

        </div>
    </div>

</body>

</html>