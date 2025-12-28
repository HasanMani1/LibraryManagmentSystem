<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// 🔐 Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// 🚦 Pending approval status ID
$pending_status_id = 4;

// Auto-selected book (from Books page)
$selected_book_id = isset($_GET['book_id']) && ctype_digit($_GET['book_id'])
    ? (int)$_GET['book_id']
    : null;

/* =========================
   HANDLE BORROW REQUEST
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $book_id  = (int)$_POST['book_id'];
    $due_date = $_POST['due_date'];

    if (!$book_id || !$due_date) {
        $errors[] = "Please select a book and due date.";
    } else {

        // ❌ BLOCK EBOOKS
        $typeStmt = $conn->prepare("
            SELECT book_type 
            FROM book 
            WHERE book_id = ?
        ");
        $typeStmt->bind_param("i", $book_id);
        $typeStmt->execute();
        $typeRes = $typeStmt->get_result();

        if ($typeRes->num_rows === 0) {
            $errors[] = "Invalid book selected.";
        } else {
            $bookType = $typeRes->fetch_assoc()['book_type'];
            if ($bookType !== 'Hardcopy') {
                $errors[] = "E-books cannot be borrowed.";
            }
        }

        if (empty($errors)) {

            // ✅ Select available copy
            $stmt = $conn->prepare("
                SELECT inventory_id 
                FROM book_inventory 
                WHERE book_id = ? AND is_available = 1
                LIMIT 1
            ");
            $stmt->bind_param("i", $book_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $errors[] = "This book is currently unavailable.";
            } else {

                $inventory_id = $result->fetch_assoc()['inventory_id'];

                $stmt = $conn->prepare("
                    INSERT INTO borrowing 
                    (user_id, inventory_id, borrow_date, due_date, status_id)
                    VALUES (?, ?, CURDATE(), ?, ?)
                ");
                $stmt->bind_param("iisi", $user_id, $inventory_id, $due_date, $pending_status_id);

                if ($stmt->execute()) {
                    logActivity($user_id, "Requested to borrow inventory ID: $inventory_id");
                    header("Location: borrow_book.php?requested=1");
                    exit;
                } else {
                    $errors[] = "Request failed. Please try again.";
                }
            }
        }
    }
}

/* =========================
   FETCH BORROWABLE BOOKS
   (HARDCOPY ONLY)
   ========================= */
$books = [];
$res = $conn->query("
    SELECT DISTINCT b.book_id, b.title, b.author
    FROM book b
    JOIN book_inventory bi ON b.book_id = bi.book_id
    WHERE 
        bi.is_available = 1
        AND b.book_type = 'Hardcopy'
    ORDER BY b.title
");

while ($r = $res->fetch_assoc()) {
    $books[] = $r;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Borrow a Book</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/saer.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding-top: 120px;
        }

        /* === Layout for footer === */
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* === Footer === */
        footer {
            width: 100%;
            background: #024187;
            color: #ffffff;
            padding: 25px 0;
            text-align: center;
            font-size: 14px;
        }

        footer p {
            margin: 6px 0;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 80px auto 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        form select,
        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: linear-gradient(135deg, #007bff, #00bfff);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
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

    <a href="book.php" class="back-btn">←Go Back</a>

    <main>

        <div class="container">
            <h1>📚 Borrow a Book</h1>

            <?php foreach ($errors as $err): ?>
                <div class="alert alert-error"><?= htmlspecialchars($err) ?></div>
            <?php endforeach; ?>

            <?php if (isset($_GET['requested'])): ?>
                <div class="alert alert-success">
                    ✅ Your request has been sent for approval.
                </div>
            <?php endif; ?>

            <form method="post">
                <label>Choose Book</label>
                <select name="book_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($books as $b): ?>
                        <option value="<?= $b['book_id'] ?>"
                            <?= $selected_book_id === (int)$b['book_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['title']) ?> — <?= htmlspecialchars($b['author']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Due Date</label>
                <input type="date" name="due_date" required min="<?= date('Y-m-d') ?>">

                <button type="submit">Submit Request</button>
            </form>
        </div>

    </main>

    <footer>
        <p>
            <br><br>Email: library@emu.edu.tr <br><br>
            Tel: +90 392 630 xxxx <br><br>
            Fax: +90 392 630 xxxx <br><br>
        </p>
    </footer>

</body>

</html>