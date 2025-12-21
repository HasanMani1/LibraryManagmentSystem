<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: unauthorized.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

// Prevent duplicate recommendation
$check = $conn->prepare(
    "SELECT rec_id FROM recommendation 
     WHERE book_id = ? AND suggested_by = ?"
);
$check->bind_param("ii", $book_id, $teacher_id);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {

    $stmt = $conn->prepare(
        "INSERT INTO recommendation (book_id, suggested_by, display_on_dashboard)
         VALUES (?, ?, 1)"
    );
    $stmt->bind_param("ii", $book_id, $teacher_id);
    $stmt->execute();
    $stmt->close();

    logActivity($teacher_id, "Recommended book ID $book_id");
}

$check->close();

header("Location: teacher_recommendations.php");
exit;
