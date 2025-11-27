<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// ✅ Check login (any logged-in user can rate)
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// ✅ Handle Rating Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = intval($_POST['book_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

    if (!$book_id || !$rating) {
        $errors[] = "Please select a book and provide a rating.";
    } else {
        // Check if user has borrowed AND returned this book
        $q = "SELECT COUNT(*) AS cnt
              FROM borrowing br
              JOIN book_inventory bi ON br.inventory_id = bi.inventory_id
              WHERE br.user_id = ? AND bi.book_id = ? AND br.status_id = 3"; // 3 = Returned
        $stmt = $conn->prepare($q);
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_assoc()['cnt'];

        if ($count == 0) {
            $errors[] = "You can only rate books you have already returned.";
        } else {
            // Check if user already rated this book
            $q = "SELECT COUNT(*) AS cnt FROM book_rating WHERE user_id = ? AND book_id = ?";
            $stmt = $conn->prepare($q);
            $stmt->bind_param("ii", $user_id, $book_id);
            $stmt->execute();
            $exists = $stmt->get_result()->fetch_assoc()['cnt'];

            if ($exists > 0) {
                $errors[] = "You have already rated this book.";
            } else {
                // Insert the rating
                $q = "INSERT INTO book_rating (user_id, book_id, rating, review, created_at)
                      VALUES (?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($q);
                $stmt->bind_param("iiis", $user_id, $book_id, $rating, $review);

                if ($stmt->execute()) {
                    logActivity($user_id, "Rated book ID: $book_id ($rating stars)");
                    $success = "Thank you for rating this book!";
                } else {
                    $errors[] = "Failed to submit rating: " . $conn->error;
                }
            }
        }
    }
}

// ✅ Fetch eligible books (returned by user)
$books = [];
$q = " SELECT DISTINCT b.book_id, b.title, b.author
    FROM book b
    JOIN book_inventory bi ON b.book_id = bi.book_id
    JOIN borrowing br ON br.inventory_id = bi.inventory_id
    WHERE br.user_id = ? AND br.status_id = 3
";
$stmt = $conn->prepare($q);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($r = $result->fetch_assoc()) $books[] = $r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rate a Book</title>
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
    .alert {
        width: 400px;
        margin: 20px auto;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
    }
    .error { background-color: #f8d7da; color: #721c24; }
    .stars {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin: 15px 0;
    }
    .stars input { display: none; }
    .stars label {
        font-size: 28px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s;
    }
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
        color: #fbc02d;
    }
  </style>
</head>
<body style="background-color: #f5f5f5;">

<div class="container">
<h1 style="text-align:center;">Rate a Book</h1>

<?php foreach ($errors as $err): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endforeach; ?>

<?php if ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (empty($books)): ?>
  <p>You currently have no returned books available for rating.</p>
<?php else: ?>
  <form method="post" class="form">
    <label for="book_id">Select Book</label>
    <select name="book_id" id="book_id" required>
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

    <label for="review">Review (Optional)</label>
    <textarea name="review" id="review" rows="4" placeholder="Share your thoughts..." class="form-control"></textarea>

    <button type="submit" class="btn btn-primary mt-3">Submit Rating</button>
  </form>
<?php endif; ?>
</div>

</body>
</html>