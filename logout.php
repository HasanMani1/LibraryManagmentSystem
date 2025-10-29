<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';  

if (isset($_SESSION['user_id'])) {
    logActivity($_SESSION['user_id'], "Logged out");
}

// Destroy session AFTER logging the activity
session_unset();
session_destroy();

header("Location: user_login.php");
exit;
?>
