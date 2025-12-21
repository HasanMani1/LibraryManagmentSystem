<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

// Prevent duplicate wishlist entries
$check = $conn->prepare(
    "SELECT wishlist_id FROM wishlist WHERE user_id = ? AND book_id = ?"
);
$check->bind_param("ii", $user_id, $book_id);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    $insert = $conn->prepare(
        "INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)"
    );
    $insert->bind_param("ii", $user_id, $book_id);
    $insert->execute();
    $insert->close();

    // ✅ Correct logging (your function)
    logActivity($user_id, "Added book ID $book_id to wishlist");
}

$check->close();

// Redirect back to books page
header("Location: Book.php");
exit;
