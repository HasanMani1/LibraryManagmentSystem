<?php
session_start();
include 'db_connect.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("No book ID provided.");
}

$book_id = intval($_GET['id']);

// Remove all copies
$conn->query("DELETE FROM book_inventory WHERE book_id = $book_id");

// Remove book
$conn->query("DELETE FROM book WHERE book_id = $book_id");

// Redirect back to manage books
header("Location: manage_book.php");
exit;
?>