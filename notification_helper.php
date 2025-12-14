<?php
include 'db_connect.php';

function createNotification($user_id, $title, $message) {
    global $conn;
    $stmt = $conn->prepare(
        "INSERT INTO notification (user_id, title, message)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("iss", $user_id, $title, $message);
    $stmt->execute();
    $stmt->close();
}
