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
<style> 
         body {
         
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
</style>
<body >


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
                <a href="librarian_dashboard.php" class="btn btn-secondary">Go back</a>
            </div>
        </div>
    </div>
</section>


</body>
</html>
