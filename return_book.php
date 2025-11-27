<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

 //✅ Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
   exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// ✅ Handle Return Book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = intval($_POST['borrow_id']);

    if (!$borrow_id) {
        $errors[] = "Invalid book selection.";
    } else {
        // Check if record exists and not yet returned
        $q = "SELECT inventory_id, status_id FROM borrowing WHERE borrowing_id = ? AND user_id = ?";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("ii", $borrow_id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $errors[] = "Borrow record not found.";
        } else {
            $row = $res->fetch_assoc();

            if ($row['status_id'] == 2) { // assuming 2 = returned
                $errors[] = "Book already returned.";
            } else {
                $inventory_id = $row['inventory_id'];

                // Update borrowing record
                $updateBorrow = $conn->prepare("UPDATE borrowing SET returned_date = CURDATE(), status_id = 2 WHERE borrowing_id = ?");
                $updateBorrow->bind_param("i", $borrow_id);

                // Mark the book copy as available again
                $updateInventory = $conn->prepare("UPDATE book_inventory SET is_available = 1 WHERE inventory_id = ?");
                $updateInventory->bind_param("i", $inventory_id);

                if ($updateBorrow->execute() && $updateInventory->execute()) {
                    // Log user activity
                    logActivity($user_id, "Returned book copy ID: $inventory_id");
                    $success = "Book returned successfully.";
                } else {
                    $errors[] = "Return failed: " . $conn->error;
                }
            }
        }
    }
}

// ✅ Fetch user's active borrowings
$active = [];
$q = "SELECT   br.borrowing_id,
        b.title,
        b.author,
        br.borrow_date,
        br.due_date
    FROM borrowing br
    JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
    JOIN book b ON bi.book_id = b.book_id
    WHERE br.user_id = ? AND br.status_id = 1  -- assuming 1 = borrowed
    ORDER BY br.due_date
";
$stmt = $conn->prepare($q);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($r = $res->fetch_assoc()) $active[] = $r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Return Book</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        flex-direction: column;
        height: 800px;
    }
    .form {
        background-color: rgba(255, 255, 255, 0.96);
        width: 400px;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        text-align: center;
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
  <h1>Return Book</h1>

  <?php foreach ($errors as $err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
  <?php endforeach; ?>
  
  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if (empty($active)): ?>
    <p>You have no borrowed books to return.</p>
  <?php else: ?>
    <form method="post" class="form">
      <label for="borrow_id">Select borrowed book</label>
      <select name="borrow_id" id="borrow_id" class="form-select" required>
        <option value="">-- Select --</option>
        <?php foreach ($active as $a): ?>
          <option value="<?= $a['borrowing_id'] ?>">
            <?= htmlspecialchars($a['title']) ?> — <?= htmlspecialchars($a['author']) ?> (Due: <?= $a['due_date'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary mt-3">Return</button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>