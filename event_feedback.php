<?php
include 'db_connect.php';
session_start();

// ✅ Check login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location='sign_up.php';</script>";
    exit;
}

$user_id = intval($_SESSION['user_id']);

// ✅ Check if event_id is provided
if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
    echo "<script>alert('Invalid event selected.'); window.location='event_list.php';</script>";
    exit;
}

$event_id = intval($_GET['event_id']);

// ✅ Verify registration
$check = $conn->prepare("SELECT * FROM event_attendance WHERE user_id = ? AND event_id = ?");
$check->bind_param("ii", $user_id, $event_id);
$check->execute();
$registered = $check->get_result();

if ($registered->num_rows == 0) {
    echo "<script>alert('⚠️ You are not registered for this event.'); window.location='my_events.php';</script>";
    exit; 
}

// ✅ Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = trim($_POST['feedback']);

    $sql = "UPDATE event_attendance SET feedback = ? WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $feedback, $event_id, $user_id);
    $stmt->execute();

    echo "<script>alert('✅ Thank you for your feedback!'); window.location='my_events.php';</script>";
    exit;
}

// ✅ Fetch event title safely
$event_stmt = $conn->prepare("SELECT title FROM event WHERE event_id = ?");
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event = $event_stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Feedback</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h3>Feedback for <strong><?= htmlspecialchars($event['title'] ?? 'Unknown Event') ?></strong></h3>
    <form method="POST">
        <textarea name="feedback" class="form-control" rows="5" placeholder="Write your feedback here..." required></textarea><br>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>
</body>
</html>
