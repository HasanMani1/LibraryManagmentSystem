<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

/* =========================
   AUTH CHECK
   ========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$pending_status_id = 4;
$errors = [];

/* =========================
   AUTO-SELECT BOOK
   ========================= */
$selected_book_id = null;
if (isset($_GET['book_id']) && ctype_digit($_GET['book_id'])) {
    $selected_book_id = (int)$_GET['book_id'];
}

/* =========================
   HANDLE BORROW REQUEST
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $book_id  = (int)($_POST['book_id'] ?? 0);
    $due_date = $_POST['due_date'] ?? '';

    if (!$book_id || !$due_date) {
        $errors[] = "Please select a book and due date.";
    } else {

        /* =========================
           UNIFIED INVENTORY LOGIC
           ========================= */
        $stmt = $conn->prepare("
            SELECT inventory_id
            FROM book_inventory
            WHERE book_id = ?
              AND is_available = 1
            LIMIT 1
        ");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $invRes = $stmt->get_result();

        if ($invRes->num_rows === 0) {
            $errors[] = "This book is currently unavailable.";
        } else {

            $inventory_id = (int)$invRes->fetch_assoc()['inventory_id'];

            $stmt = $conn->prepare("
                INSERT INTO borrowing
                (user_id, inventory_id, borrow_date, due_date, status_id)
                VALUES (?, ?, CURDATE(), ?, ?)
            ");
            $stmt->bind_param(
                "iisi",
                $user_id,
                $inventory_id,
                $due_date,
                $pending_status_id
            );

            if ($stmt->execute()) {
                logActivity($user_id, "Requested to borrow inventory ID $inventory_id");
                header("Location: borrow_book.php?requested=1");
                exit;
            } else {
                $errors[] = "Borrow request failed.";
            }
        }
    }
}

/* =========================
   FETCH ALL BOOKS
   ========================= */
$books = [];
$res = $conn->query("
    SELECT DISTINCT 
        b.book_id,
        b.title,
        b.author,
        b.book_type
    FROM book b
    LEFT JOIN book_inventory bi ON b.book_id = bi.book_id
    ORDER BY b.title
");

while ($row = $res->fetch_assoc()) {
    $books[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Borrow a Book</title>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding-top: 120px;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }

        main {
            flex: 1;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #94a3b8;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        select,
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 2px solid #94a3b8;
        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
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
    </style>
</head>

<body>

    <a href="book.php" class="back-btn">← Go Back</a>

    <main>
        <div class="container">
            <h1>Borrow a Book</h1>

            <?php foreach ($errors as $e): ?>
                <div class="alert alert-error"><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>

            <?php if (isset($_GET['requested'])): ?>
                <div class="alert alert-success">Your request has been sent for approval.</div>
            <?php endif; ?>

            <form method="post">
                <label>Choose Book</label>
                <select name="book_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($books as $b): ?>
                        <option value="<?= $b['book_id'] ?>"
                            <?= ($selected_book_id === (int)$b['book_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['title']) ?> — <?= htmlspecialchars($b['author']) ?>
                            (<?= $b['book_type'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Due Date</label>
                <input type="date" name="due_date" min="<?= date('Y-m-d') ?>" required>

                <button type="submit">Submit Request</button>
            </form>
        </div>
    </main>

</body>

</html>