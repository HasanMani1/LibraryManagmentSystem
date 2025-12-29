<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// ✅ Only logged-in users
if (!isset($_SESSION['user_id'])) {
  header("Location: user_login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// ----------------------
// HANDLE RATING SUBMISSION
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $book_id = intval($_POST['book_id']);
  $rating_value = intval($_POST['rating']);
  $comment = trim($_POST['comment']);

  if (!$book_id || !$rating_value) {
    $errors[] = "Please select a book and provide a rating.";
  } else {
    $stmtCheck = $conn->prepare("SELECT COUNT(*) AS cnt FROM book_rating WHERE user_id = ? AND book_id = ?");
    $stmtCheck->bind_param("ii", $user_id, $book_id);
    $stmtCheck->execute();
    $exists = $stmtCheck->get_result()->fetch_assoc()['cnt'];

    if ($exists > 0) {
      $errors[] = "You have already rated this book.";
    } else {
      $stmtBorrow = $conn->prepare("
        SELECT br.borrowing_id
        FROM borrowing br
        JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
        WHERE br.user_id = ? AND bi.book_id = ? AND br.status_id = 2
        ORDER BY br.borrow_date DESC
        LIMIT 1
      ");
      $stmtBorrow->bind_param("ii", $user_id, $book_id);
      $stmtBorrow->execute();
      $borrowRow = $stmtBorrow->get_result()->fetch_assoc();

      if (!$borrowRow) {
        $errors[] = "This book is not eligible for rating (not returned).";
      } else {
        $stmtInsert = $conn->prepare("
          INSERT INTO book_rating (user_id, book_id, rating_value, comment, created_at)
          VALUES (?, ?, ?, ?, NOW())
        ");
        $stmtInsert->bind_param("iiis", $user_id, $book_id, $rating_value, $comment);

        if ($stmtInsert->execute()) {
          logActivity($user_id, "Rated book ID: $book_id ($rating_value stars)");
          $success = "Thank you for rating this book!";
        } else {
          $errors[] = "Failed to submit rating.";
        }
      }
    }
  }
}

// ----------------------
// FETCH RETURNED BOOKS
// ----------------------
$books = [];
$stmt = $conn->prepare("
  SELECT DISTINCT b.book_id, b.title, b.author
  FROM borrowing br
  JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
  JOIN book b ON bi.book_id = b.book_id
  WHERE br.user_id = ? AND br.status_id = 2
  ORDER BY b.title ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($r = $result->fetch_assoc()) {
  $books[] = $r;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Rate Returned Books</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
      margin: 0;

      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-content {
      flex: 1;
    }

    .container {
      width: 90%;
      max-width: 700px;
      margin: 60px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 2px solid #94a3b8;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .stars {
      display: flex;
      justify-content: center;
      gap: 5px;
    }

    .stars input {
      display: none;
    }

    .stars label {
      font-size: 28px;
      color: #000000ff;
      cursor: pointer;
    }

    .stars input:checked~label,
    .stars label:hover,
    .stars label:hover~label {
      color: #fbc02d;
    }

    button {
      background: linear-gradient(135deg, #007bff, #00bfff);
      border: none;
      color: white;
      padding: 10px;
      border-radius: 6px;
    }

    .back-btn {
      position: fixed;
      top: 25px;
      left: 25px;
      padding: 10px 18px;
      border-radius: 50px;
      background: linear-gradient(135deg, #007bff, #00bfff);
      color: white;
      font-weight: bold;
      text-decoration: none;
    }
.form-control{
    border: 2px solid #94a3b8;
}

  </style>
</head>

<body>

  <div class="main-content">
    <div class="container">
      <h1>Rate Returned Books</h1>

      <?php foreach ($errors as $err): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
      <?php endforeach; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <?php if (empty($books)): ?>
        <p>You have no returned books to rate.</p>
      <?php else: ?>
        <form method="POST">
          <label>Select Book</label>
          <select name="book_id" class="form-control" required>
            <option value="">-- Select --</option>
            <?php foreach ($books as $b): ?>
              <option value="<?= $b['book_id'] ?>">
                <?= htmlspecialchars($b['title']) ?> — <?= htmlspecialchars($b['author']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <label>Rating</label>
          <div class="stars">
            <?php for ($i = 5; $i >= 1; $i--): ?>
              <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
              <label for="star<?= $i ?>">★</label>
            <?php endfor; ?>
          </div>

          <label>Comment (Optional)</label>
          <textarea name="comment" rows="4" class="form-control"></textarea>

          <button type="submit">Submit Rating</button>
        </form>
      <?php endif; ?>
    </div>
  </div>



</body>

</html>