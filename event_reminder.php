<?php
include 'db_connect.php';
include 'notifications.php';

// Approved events → notify all users
$sql = "SELECT e.event_id, e.title, u.user_id
FROM event e
CROSS JOIN user u
WHERE e.is_approved = 1
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    $title = "Approved Library Event";
    $message = "A new library event has been approved: '{$row['title']}'.";

    createNotification(
        $row['user_id'],
        $title,
        $message
    );
}
