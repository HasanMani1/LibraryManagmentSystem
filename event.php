<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

if (!isset($_GET['id'])) {
    die("Invalid event.");
}

$eventId = (int) $_GET['id'];

/* 🔐 Force login */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=event.php?id=$eventId");
    exit;
}

$userId = $_SESSION['user_id'];

/* Fetch event */
$eventRes = $conn->query(
    "SELECT * FROM event WHERE event_id = $eventId"
);

if ($eventRes->num_rows === 0) {
    die("Event not found.");
}

$event = $eventRes->fetch_assoc();

/* Check attendance status */
$attRes = $conn->query(
    "SELECT * FROM event_attendance 
     WHERE event_id = $eventId AND user_id = $userId"
);

$alreadyAttended = false;

if ($attRes->num_rows > 0) {
    $row = $attRes->fetch_assoc();
    $alreadyAttended = ($row['attended'] == 1);
}

if (isset($_POST['attend'])) {

    if ($event['capacity'] > 0 && !$alreadyAttended) {

        if ($attRes->num_rows == 0) {
            $conn->query(
                "INSERT INTO event_attendance (event_id, user_id, attended)
                 VALUES ($eventId, $userId, 1)"
            );
        } else {
            $conn->query(
                "UPDATE event_attendance
                 SET attended = 1
                 WHERE event_id = $eventId AND user_id = $userId"
            );
        }

        $conn->query(
            "UPDATE event
             SET capacity = capacity - 1
             WHERE event_id = $eventId"
        );

        header("Location: final_event_list.php?id=$eventId&success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Attendance</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
          body {
        
            background-size: cover;

            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;

            padding-top: 140px;
        }
.attendance-card {
    width: 260px;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    text-align: center;
}

.attendance-card button {
    padding: 6px 14px;
    font-size: 14px;
}
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
    border-radius: 50px;
    padding: 10px 18px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    z-index: 1000;
}
       .container {
            border: 2px solid #94a3b8;
            border-radius: 10px;
            padding: 20px;
            background: white;
        }
</style>
</head>

<body class="d-flex justify-content-center align-items-center" style="min-height:100vh;">

<div class="container d-flex justify-content-between align-items-center gap-4">

    <!-- LEFT: Event info -->
    <div>
        <h5 class="mb-1"><?= htmlspecialchars($event['title']) ?></h5>
        <p class="small mb-0">
            Remaining: <strong><?= $event['capacity'] ?></strong>
        </p>
    </div>

    <!-- RIGHT: Action buttons -->
    <div class="text-end">

        <?php if ($alreadyAttended): ?>
            <span class="badge bg-success px-3 py-2">✔ Attending</span>

        <?php elseif ($event['capacity'] > 0): ?>
            <form method="post" class="d-inline">
                <button name="attend" class="btn btn-primary btn-sm px-3">
                    Attendance
                </button>
            </form>

        <?php else: ?>
            <span class="badge bg-danger px-3 py-2">Event Full</span>
        <?php endif; ?>

    </div>

</div>


</body>
</html>


