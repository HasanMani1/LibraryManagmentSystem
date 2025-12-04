<?php

include 'db_connect.php';
session_start();

// Make sure user is logged in
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id  = $_POST['event_id'];
    $attended  = isset($_POST['attended']) ? 1 : 0;
    $feedback  = $_POST['feedback'];

    $sql = "INSERT INTO event_attendance (event_id, user_id, attended, feedback)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $event_id, $user_id, $attended, $feedback);

    if ($stmt->execute()) {
        header("Location: event_attendance_list.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


?>