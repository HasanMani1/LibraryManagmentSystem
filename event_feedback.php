<?php
include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $event_name = trim($_POST['event_name']);
    $rating     = intval($_POST['rating']);
    $comments   = trim($_POST['comments']);
    $email      = trim($_POST['email']);

    if (empty($event_name) || empty($rating) || empty($comments)) {
        echo "Missing required fields.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO event_feedback (event_name, rating, comments, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $event_name, $rating, $comments, $email);

    if ($stmt->execute()) {
        $message = "Thank you! Your feedback has been saved.";
    } else {
        $message = "Database error: " . $conn->error;
    }
}

// Fetch All Feedback
$result = $conn->query("SELECT * FROM event_feedback ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Event Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/img_14901_3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        section {
            min-height: 100vh;
            display: flex;
            justify-content: center;   
            align-items: center;        
            background: transparent;
        }

        .container {
            width: 90%;
            margin: auto;
            background: rgba(255,255,255,0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header-text {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
            color: #141313ff;
        }

        .msg {
            background: #d4edda;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin-bottom: 20px;
            width: 60%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #aaa;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

    </style>
</head>

    <body>

    <?php if (!empty($message)): ?>
        <div class="msg">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <section>
        
        <div class="container">

  
  <div class="header-text">All Feedback</div>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Email</th>
                <th>Date</th>
            </tr>
            </thead>

                <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="align-bottom">
                <td><?= $row['id'] ?></td>
                <td><?= $row['event_name'] ?></td>
                <td><?= $row['rating'] ?></td>
                <td><?= $row['comments'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php endwhile; ?>
        </table>
    </div>
    </div>
 </section>

</body>
</html>
