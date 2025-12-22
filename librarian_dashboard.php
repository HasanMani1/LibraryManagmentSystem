<?php
session_start();
include 'db_connect.php';
$timeout_duration = 900; // 15 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: user_login.php?session=expired");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Restrict access: only librarians (role_id = 2)
if ($_SESSION['role_id'] != 2) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f5f5f5;">

<header>
    <div class="logo">
        <img src="images/emu-dau-logo.png" alt="EMU Logo">
        <div class="head">
            <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
            <h4 style="color: white; padding-left:80px;">ONLINE LIBRARY MANAGEMENT SYSTEM</h4>
        </div>
    </div>

    <nav>
        <ul>
         
        </ul>
    </nav>
</header>

<section style="padding: 40px; text-align:center;">
    <div class="container">
        <h2>📚 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <hr>
        <div class="card mx-auto mt-4" style="width: 70%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h4 class="card-title">Librarian Dashboard</h4>
                <p class="card-text">You can manage and monitor library operations here:</p>
                <ul style="text-align:left; display:inline-block;">
                    <li>📖 Manage books and inventory</li>
                    <li>🔄 Handle borrow and return requests</li>
                    <li>📅 Organize and approve book donations</li>
                                <li>📅 Organize and check the events</li>
                </ul>
                <br>
                <a href="event_proposal.php" class="btn btn-success">Proposed Events</a>
                 <a href="manage_borrow.php" class="btn btn-primary">Manage Borrow Book</a>
                <a href="manage_return.php" class="btn btn-primary">Manage Return Book</a>
                <a href="manage_donate.php" class="btn btn-primary">Manage Donation</a>
                 <a href="manage_book.php" class="btn btn-primary">Manage Book</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <p style="color: white; text-align:center;">
        <br><br>Email: &nbsp;library@emu.edu.tr <br><br>
        Tel: &nbsp;+90 392 630 xxxx <br><br>
        Fax: &nbsp;+90 392 630 xxxx <br><br>
    </p>
</footer>

</body>
</html>
