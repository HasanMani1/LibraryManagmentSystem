<?php
// log_activity.php
include 'db_connect.php';

function logActivity($user_id, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $action);
    $stmt->execute();
    $stmt->close();
}
?>
