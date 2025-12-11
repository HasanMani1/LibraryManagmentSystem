<?php
session_start();
$timeout_duration = 900; // 15 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: user_login.php?session=expired");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
include 'db_connect.php';
// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: student_login.php");
    exit;
}

// ✅ Restrict access: only students (role_id = 4)
if ($_SESSION['role_id'] != 4) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
         body {
            background-image: url('images/library-books.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        section {
            background: transparent;
        }
        h2 {
            display: inline-block;                  
            padding: 12px 25px;                     
            background: rgba(255, 255, 255, 0.25);  
            backdrop-filter: blur(10px);            
            -webkit-backdrop-filter: blur(10px);    
            border-radius: 12px;                    
            color: white;                           
            font-weight: bold;
        }



</style>
<body >

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
            <li><a href="home.html">HOME</a></li>
            <li><a href="#">BOOKS</a></li>
            <li><a href="#">E-BOOKS</a></li>
            <li><a href="#">EVENTS</a></li>
            <li><a href="track_event_attendance">ATTENDANCE</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
    </nav>
</header>

<section style="padding: 40px; text-align:center;">
    <div class="container">
        <h2>🎓 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <hr>
        <div class="card mx-auto mt-4" style="width: 60%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h4 class="card-title">Student Dashboard</h4>
                <p class="card-text">From here, you’ll be able to:</p>
                <ul style="text-align:left; display:inline-block;">
                    <li>View and borrow books 📚</li>
                    <li>Check your borrowed history 🕓</li>
                    <li>Rate and review books ⭐</li>
                    <li>Get reminders or notifications 🔔</li>
                </ul>
                <br>
                <a href="library_hours.php" class="btn btn-success">Library Hours</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <p style="color: white; text-align:center;">
        <br><br>Email: &nbsp; library@emu.edu.tr <br><br>
        Tel: &nbsp; +90 392 630 xxxx <br><br>
        Fax: &nbsp; +90 392 630 xxxx <br><br>
    </p>
</footer>

</body>
</html>
