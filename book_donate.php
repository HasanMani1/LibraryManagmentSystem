<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$success = "";
$error = "";

// Load available categories
$categories = $conn->query("SELECT category_id, category_name FROM book_category");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $donor_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $book_type = isset($_POST['book_type']) && $_POST['book_type'] !== "" ? $_POST['book_type'] : "General";
    $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== "" ? intval($_POST['category_id']) : null;
    $copies = intval($_POST['copies']);

    if ($title === "" || $copies < 1) {
        $error = "Title and at least 1 copy are required.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO book_donation (donor_id, book_title, status, is_approved)
            VALUES (?, ?, 'Pending', 0)
        ");
        $stmt->bind_param("is", $donor_id, $title);

        if ($stmt->execute()) {
            $success = "Book donation submitted successfully! Awaiting admin approval.";
        } else {
            $error = "Failed to submit donation. Please try again.";
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="number"],
        select {
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
            width: 100%;
            font-size: 16px;
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
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 18px;
            text-decoration: none;
            z-index: 1000;
        }

        footer {
            width: 100%;
            background-color: #024187;
            color: white;
            padding: 25px 0;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <div class="container">
            <h2>📖 Donate a Book</h2>

            <?php if ($success): ?>
                <div class="alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <label>Title</label>
                <input type="text" name="title" required>

                <label>Author</label>
                <input type="text" name="author">

                <label>ISBN</label>
                <input type="text" name="isbn">

                <label>Book Type</label>
                <input type="text" name="book_type" placeholder="e.g. Hardcover, eBook, PDF">

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

                <button type="submit">Submit Donation</button>
            </form>
        </div>
    </div>

    <footer>
        <p>
            Email: library@emu.edu.tr<br><br>
            Tel: +90 392 630 xxxx<br><br>
            Fax: +90 392 630 xxxx
        </p>
    </footer>

</body>

</html>