<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// ✅ Check login (any logged-in user can borrow)
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
        // Check if a copy is available
        $q = "SELECT inventory_id FROM book_inventory WHERE book_id = ? AND is_available = 1 LIMIT 1";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "No available copies for this book.";
        } else {
            $row = $result->fetch_assoc();
            $inventory_id = $row['inventory_id'];

            // Insert into borrowing table
            $q = "INSERT INTO borrowing (user_id, inventory_id, borrow_date, due_date, status_id)
                  VALUES (?, ?, CURDATE(), ?, 1)";
            $stmt = $conn->prepare($q);
            $stmt->bind_param("iis", $user_id, $inventory_id, $due_date);

            if ($stmt->execute()) {
                // Mark that copy as unavailable
                $conn->query("UPDATE book_inventory SET is_available = 0 WHERE inventory_id = $inventory_id");

                // Log activity
                logActivity($user_id, "Borrowed book copy ID: $inventory_id");

                $success = "Book borrowed successfully!";
            } else {
                $errors[] = "Borrow failed: " . $conn->error;
            }
        }
    }
}

// ✅ Fetch list of available books
$books = [];
$q = "
    SELECT b.book_id, b.title, b.author, COUNT(bi.inventory_id) AS available_copies
    FROM book b
    JOIN book_inventory bi ON b.book_id = bi.book_id
    WHERE bi.is_available = 1
    GROUP BY b.book_id, b.title, b.author
    ORDER BY b.title
";
$res = $conn->query($q);
while ($r = $res->fetch_assoc()) $books[] = $r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrow a Book</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        flex-direction: column;
    }
    .form {
        background-color: rgba(255, 255, 255, 0.96);
        width: 400px;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        text-align: center;
    }  
    button {
            background: linear-gradient(135deg, #007bff, #00bfff);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background: linear-gradient(135deg, #0056b3, #0080ff);
            transform: scale(1.05);
        }

        .alert {
            width: 400px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }

        .error { background-color: #f8d7da; color: #721c24; }
        .warning { background-color: #fff3cd; color: #856404; }
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
<body style="background-color: #f5f5f5;">


<div class="container">
<h1 style="text-align:center;">Borrow a Book</h1>

<?php foreach ($errors as $err): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endforeach; ?>

<?php if ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (empty($books)): ?>
  <p>No books available right now.</p>
<?php else: ?>
  <form method="post" class="form">
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
    <input type="date" name="due_date" id="due_date" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">

    <button type="submit" class="btn btn-primary mt-3">Borrow</button>
  </form>
<?php endif; ?>
</div>
>
</body>
</html>
