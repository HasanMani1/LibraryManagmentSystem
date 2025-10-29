<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Default destination (if not logged in)
$backLink = "user_login.php";

// Determine where to go based on the user's role
if (isset($_SESSION['role_id'])) {
    switch ($_SESSION['role_id']) {
        case 1:
            $backLink = "admin_dashboard.php";
            break;
        case 2:
            $backLink = "librarian_dashboard.php";
            break;
        case 3:
            $backLink = "teacher_dashboard.php";
            break;
        case 4:
            $backLink = "student_dashboard.php";
            break;
    }
}
?>

<!-- Go Back Button -->
<a href="<?= $backLink; ?>" class="back-btn">
    <i class="bi bi-arrow-left"></i> Go Back
</a>
