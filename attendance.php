<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit; 
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$role_id = $_SESSION['role_id']; // 1=Student, 2=Teacher, 3=Admin

$event_id = intval($_GET['event_id'] ?? 0);
if ($event_id <= 0) die("Invalid event.");

// Get event info
$eventStmt = $conn->prepare("SELECT title, description, capacity FROM event WHERE event_id = ?");
$eventStmt->bind_param("i", $event_id);
$eventStmt->execute();
$event = $eventStmt->get_result()->fetch_assoc();

if (!$event) die("Event not found.");

// Count attendance
$countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM attendance WHERE event_id = ?");
$countStmt->bind_param("i", $event_id);
$countStmt->execute();
$total = $countStmt->get_result()->fetch_assoc()['total'];

$available = $event['capacity'] - $total;

// If submitted
if (isset($_POST['attend'])) {
    if ($available <= 0) {
        echo "<script>alert('This event is full.');</script>";
    } else {
        $insert = $conn->prepare("INSERT INTO attendance (event_id, attendee_name, attendee_email) 
                                  SELECT ?, name, email FROM users WHERE user_id = ?");
        $insert->bind_param("ii", $event_id, $user_id);
        $insert->execute();

        echo "<script>alert('Attendance registered successfully!'); window.location.href='attendance_list.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Proposals</title>
<link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
            body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            background-image: url('images/library-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
           .summary-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 18px;
    margin: 25px auto;
    width: 80%;
}

</style>
</head>

<body>
    <header>
    <div class="logo">
        <img src="images/emu-dau-logo.png" alt="EMU Logo">
        <div class="head">
            <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
            <h4 style="color: white; padding-left:80px;">ONLINE LIBRARY MANAGEMENT SYSTEM</h4>
            </div>
    </div>
        <nav>
        <ul>
            <li><a href="admin_dashboard.php">HOME</a></li>
            <li><a href="event_list.php">EVENTS</a></li>
            <li><a href="notification.php">NOTIFICATIONS</a></li>
            <li><a href="">FEEDBACK</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </nav>
    </header>
<section> 
<div class="container bg-white p-4 rounded shadow-sm" style="max-width:600px;">
    <h3 class="text-center mb-3">Attend Event</h3>
    <h5><?= htmlspecialchars($event['title']) ?></h5>
    <p><?= htmlspecialchars($event['description']) ?></p>
    <p><strong>Available Seats:</strong> <?= $available ?></p>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" value="<?= htmlspecialchars($name) ?>" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="text" value="<?= $role_id == 1 ? 'Student' : ($role_id == 2 ? 'Teacher' : 'Admin') ?>" class="form-control" readonly>
        </div>
        <button type="submit" name="attend" class="btn btn-primary w-100" 
            <?= $available <= 0 ? 'disabled' : '' ?>>
            <?= $available <= 0 ? 'Event Full' : 'Confirm Attendance' ?>
        </button>
    </form>
</div>
</section>
<footer>
    <p style="color: white; text-align:center;">
        <br><br>Email: &nbsp;library@emu.edu.tr <br><br>
        Tel: &nbsp;+90 392 630 xxxx <br><br>
        Fax: &nbsp;+90 392 630 xxxx <br><br>
    </p>
</footer>
</body>
</html>
