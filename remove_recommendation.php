<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    exit;
}

$rec_id = intval($_GET['id']);
$teacher_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "DELETE FROM recommendation 
     WHERE rec_id = ? AND suggested_by = ?"
);
$stmt->bind_param("ii", $rec_id, $teacher_id);
$stmt->execute();
$stmt->close();

header("Location: teacher_recommendations.php");
exit;
