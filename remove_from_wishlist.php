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
$wishlist_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($wishlist_id <= 0) {
    header("Location: wishlist.php");
    exit;
}

// Ensure the wishlist item belongs to this user
$check = $conn->prepare(
    "SELECT book_id FROM wishlist WHERE wishlist_id = ? AND user_id = ?"
);
$check->bind_param("ii", $wishlist_id, $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows === 1) {
    $check->bind_result($book_id);
    $check->fetch();

    $delete = $conn->prepare(
        "DELETE FROM wishlist WHERE wishlist_id = ? AND user_id = ?"
    );
    $delete->bind_param("ii", $wishlist_id, $user_id);
    $delete->execute();
    $delete->close();

    // ✅ Correct activity logging
    logActivity($user_id, "Removed book ID $book_id from wishlist");
}

$check->close();

header("Location: wishlist.php");
exit;
