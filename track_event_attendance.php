<?php
session_start();
include 'db_connect.php';

// Get event_id from URL
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

// Fetch event title
$event = null;
if ($event_id > 0) {
    $res = $conn->query("SELECT title FROM event WHERE event_id = $event_id");
    if ($res && $res->num_rows > 0) {
        $event = $res->fetch_assoc();
    }
}
if (!$event) {
    echo "<script>alert('Event not found. Returning to event list.'); window.location='event_list.php';</script>";
    exit;
}


// Handle attendance update
if (isset($_POST['update'])) {
    foreach ($_POST['attendance'] as $user_id => $value) {
        $attended = $value == '1' ? 1 : 0;
        $sql = "UPDATE event_attendance SET attended = ? WHERE event_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $attended, $event_id, $user_id);
        $stmt->execute();
    }
    echo "<script>alert('Attendance updated successfully!');</script>";
}

// Fetch all users registered for this event
$query = "SELECT ea.user_id, u.name, ea.attended, ea.feedback
FROM event_attendance ea
JOIN user u ON ea.user_id = u.user_id
WHERE ea.event_id = $event_id
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Track Attendance - <?= htmlspecialchars($event['title']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <a href="event_list.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
    <h3>Track Attendance for: <strong><?= htmlspecialchars($event['title'] ?? '') ?></strong></h3>
    <form method="POST">
        <table class="table table-bordered mt-3">
            <thead class="table-primary">
                <tr>
                    <th>Participant</th>
                    <th>Attended</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <select name="attendance[<?= $row['user_id'] ?>]" class="form-select">
                            <option value="0" <?= $row['attended'] == 0 ? 'selected' : '' ?>>Not Attended</option>
                            <option value="1" <?= $row['attended'] == 1 ? 'selected' : '' ?>>Attended</option>
                        </select>
                    </td>
                    <td><?= htmlspecialchars($row['feedback'] ?? 'No feedback yet') ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit" name="update" class="btn btn-success">Save Changes</button>
    </form>
</div>
</body>
</html>
