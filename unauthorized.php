<?php
session_start();

// Optionally, destroy session to prevent looping attempts
// session_unset();
// session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Denied</title>
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
            <li><a href="home.html">HOME</a></li>
            <li><a href="user_login.php">LOGIN</a></li>
        </ul>
    </nav>
</header>

<section style="padding: 100px; text-align:center;">
    <div class="container">
        <div class="card mx-auto" style="width: 60%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h2 class="card-title text-danger">🚫 Access Denied</h2>
                <p class="card-text" style="font-size: 18px;">
                    You do not have permission to access this page.
                </p>
                <p style="font-size: 16px; color: #666;">
                    Please log in with the appropriate account or return to the home page.
                </p>
                <br>
                <a href="user_login.php" class="btn btn-primary">Go to Login</a>
                <a href="home.html" class="btn btn-secondary">Back to Home</a>
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
