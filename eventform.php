<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
// Fetch events
$events = $conn->query("SELECT event_id, title FROM event");

// Fetch users (students)
$students = $conn->query(" SELECT user.user_id, user.name  FROM user 
    INNER JOIN role ON user.role_id = role.role_id
    WHERE role.role_name = 'Student'
    ORDER BY user.name ASC
");
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id   = intval($_POST['event_id']);
    $user_id    = intval($_POST['user_id']);
    $attended   = intval($_POST['attended']); 
    $feedback   = $_POST['feedback'];
    $time_now   = date("Y-m-d H:i:s");

    $query = "INSERT INTO event_attendance (event_id, user_id, attended, feedback, feedback_time)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $event_id, $user_id, $attended, $feedback, $time_now);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance recorded successfully!');</script>";
        echo "<script>window.location.href='event_attendance_list.php';</script>";
    } else {
        echo "<script>alert('Failed to record attendance.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mark Event Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
      
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
    }

    .event-card {
        max-width: 600px;
        margin: 60px auto;
        padding: 30px;
        border-radius: 20px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
         border: 2px solid #94a3b8;
    }

    .header-text {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 1.8rem;
        color: #2c3e50;
    }

    .btn-custom {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        font-weight: bold;
    }
    .form-control{
            border: 2px solid #94a3b8;
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

<body>

<div class="event-card">

    <div class="header-text">Mark Event Attendance</div>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Select Event</label>
            <select name="event_id" class="form-control" required>
                <option value="">-- Choose Event --</option>
                <?php while($e = $events->fetch_assoc()): ?>
                    <option value="<?= $e['event_id'] ?>">
                        <?= htmlspecialchars($e['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Choose Student --</option>
                <?php while($s = $students->fetch_assoc()): ?>
                    <option value="<?= $s['user_id'] ?>">
                        <?= htmlspecialchars($s['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Attendance</label>
            <select name="attended" class="form-control" required>
                <option value="1">Present</option>
                <option value="0">Absent</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Feedback (optional)</label>
            <textarea name="feedback" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-custom">Submit Attendance</button>

    </form>
</div>

</body>
</html>
