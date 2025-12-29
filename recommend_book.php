<?php
session_start();
include 'db_connect.php';

if ($_SESSION['role_id'] != 3) {
    header("Location: unauthorized.php");
    exit;
}

$book_id = $_POST['book_id'];
$teacher_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    INSERT INTO recommendation (book_id, suggested_by, display_on_dashboard)
    VALUES (?, ?, 1)
");
$stmt->bind_param("ii", $book_id, $teacher_id);
$stmt->execute();

header("Location: book.php");
?>