<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// 🔐 Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$errors = [];
$success = "";

// ✅ Handle Borrow Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);
    $due_date = $_POST['due_date'];

    if (!$book_id || !$due_date) {
        $errors[] = "Please select a book and due date.";
    } else {
        // Check for available copy
        $stmt = $conn->prepare("SELECT inventory_id FROM book_inventory WHERE book_id = ? AND is_available = 1 LIMIT 1");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "No available copies for this book.";
        } else {
            $row = $result->fetch_assoc();
            $inventory_id = $row['inventory_id'];

            // Insert borrowing record
            $stmt = $conn->prepare("INSERT INTO borrowing (user_id, inventory_id, borrow_date, due_date, status_id) VALUES (?, ?, CURDATE(), ?, 1)");
            $stmt->bind_param("iis", $user_id, $inventory_id, $due_date);

            if ($stmt->execute()) {
                // Mark copy as unavailable
                $conn->query("UPDATE book_inventory SET is_available = 0 WHERE inventory_id = $inventory_id");

                // Log activity
                logActivity($user_id, "Borrowed book copy ID: $inventory_id");

                header("Location: borrow_book.php?success=1");
                exit;
            } else {
                $errors[] = "Borrow failed: " . $conn->error;
            }
        }
    }
}

// ✅ Fetch available books
$books = [];
$res = $conn->query("
    SELECT b.book_id, b.title, b.author, COUNT(bi.inventory_id) AS available_copies
    FROM book b
    JOIN book_inventory bi ON b.book_id = bi.book_id
    WHERE bi.is_available = 1
    GROUP BY b.book_id, b.title, b.author
    ORDER BY b.title
");
while ($r = $res->fetch_assoc()) $books[] = $r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Borrow a Book</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('images/saer.jpg');
    background-size: cover;
    background-attachment: fixed;
    margin: 0;
    padding-top: 120px;
}
.container {
    width: 90%;
    max-width: 500px;
    margin: 80px auto 50px;
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
h1 {
    text-align: center;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 25px;
}
form label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
    font-weight: 600;
}
form select, form input {
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
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: 0.3s ease-in-out;
}
button:hover {
    background: linear-gradient(135deg, #0056b3, #0080ff);
    transform: scale(1.05);
}
.alert {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
}
.alert-success { background-color: #d4edda; color: #155724; }
.alert-error { background-color: #f8d7da; color: #721c24; }
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    text-decoration: none;
    transition: all 0.3s ease-in-out;
    z-index: 1000;
}
.back-btn:hover {
    background: linear-gradient(135deg, #0056b3, #0080ff);
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    color: #f8f9fa;
}
.back-btn i { font-size: 18px; }
</style>
</head>
<body>

<a href="admin_dashboard.php" class="back-btn"><i class="bi bi-arrow-left"></i> Back</a>

<div class="container">
<h1>📚 Borrow a Book</h1>

<?php foreach ($errors as $err): ?>
  <div class="alert alert-error"><?= htmlspecialchars($err) ?></div>
<?php endforeach; ?>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success">✅ Book borrowed successfully!</div>
<?php endif; ?>

<?php if (empty($books)): ?>
  <p>No books available right now.</p>
<?php else: ?>
<form method="post">
    <label for="book_id">Choose Book</label>
    <select name="book_id" id="book_id" required>
      <option value="">-- Select --</option>
      <?php foreach ($books as $b): ?>
        <option value="<?= $b['book_id'] ?>">
          <?= htmlspecialchars($b['title']) ?> — <?= htmlspecialchars($b['author']) ?> (<?= $b['available_copies'] ?> available)
        </option>
      <?php endforeach; ?>
    </select>

    <label for="due_date">Due Date</label>
    <input type="date" name="due_date" id="due_date" required min="<?= date('Y-m-d') ?>">

    <button type="submit">Borrow</button>
</form>
<?php endif; ?>
</div>

</body>
</html>