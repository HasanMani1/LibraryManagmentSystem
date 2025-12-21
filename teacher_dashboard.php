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
    header("Location: user_login.php");
    exit;
}

// ✅ Restrict access: only teachers (role_id = 3)
if ($_SESSION['role_id'] != 3) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
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
        <h2>👩‍🏫 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <hr>
        <div class="card mx-auto mt-4" style="width: 60%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h4 class="card-title">Teacher Dashboard</h4>
                <p class="card-text">From here, you can manage your teaching-related activities:</p>
                <ul style="text-align:left; display:inline-block;">
                    <li>Recommend books for your classes 📚</li>
                    <li>View and rate academic resources ⭐</li>
                    <li>Propose or view library events 📅</li>
                    <li>See reminders and notifications 🔔</li>
                </ul>
                <br> 
                <a href="create_event.php" class="btn btn-primary">Add New Event</a>
                <a href="accepted.php" class="btn btn-primary">Events</a>
                 <a href="book.php" class="btn btn-primary">Books</a>
                <a href="borrow_book.php" class="btn btn-primary">Borrow Books</a>
                <a href="return_book.php" class="btn btn-primary">Return Books</a>
                <a href="borrow_history.php" class="btn btn-primary">Borrow History</a>
                <a href="rate_book.php" class="btn btn-primary">Rate Books</a>
                <a href="book_donate.php" class="btn btn-primary">Donate Books</a>
                <a href="view_book_ratings.php" class="btn btn-primary">View Book Ratings</a>
                <a href="contact_us.php" class="btn btn-primary"> 📩 Contact Library</a>
                 <a href="wishlist.php" class="btn btn-primary">Wishlist</a>
                   <a href="teacher_recommendations.php" class="btn btn-primary">My Recommendations</a>
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
