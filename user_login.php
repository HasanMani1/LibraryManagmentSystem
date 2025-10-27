<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']); // assuming username = email
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, name, email, password, role_id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // ✅ Login success
            logActivity($row['user_id'], "Logged in successfully");
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role_id'] = $row['role_id'];

            // ✅ Redirect based on role
            switch ($row['role_id']) {
                case 1: header("Location: admin_dashboard.php"); break;
                case 2: header("Location: librarian_dashboard.php"); break;
                case 3: header("Location: teacher_dashboard.php"); break;
                case 4: header("Location: student_dashboard.php"); break;
                default: header("Location: unauthorized.php");
            }
            exit;
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "⚠️ No user found with that email.";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Login</title>
</head>
<body>
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
            <li><a href="#">BOOKS/E-BOOKS</a></li>
            <li><a href="user_login.php">LOGIN</a></li>
            <li><a href="student_registration.html">STUDENT-REGISTRATION</a></li>
            <li><a href="#">FEEDBACK</a></li>
        </ul>
    </nav>
</header>

<section>
    <center>       
        <div class="std_log_in">
            <br><br><br>
            <div class="box1">
                <h1 style="text-align: center; font-size: 35px; font-family: Lucida Console;">Library Management System</h1><br>
                <h1 style="text-align: center; font-size: 25px;">User Login Form</h1>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" style="width: 60%; margin:auto;"><?= $error; ?></div>
                <?php endif; ?>

                <form name="login" method="POST">
                    <div class="login">
                        <input class="form-control" type="text" name="username" placeholder="Email Address" required> 
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                        <input class="btn btn-primary" type="submit" name="submit" value="Login">
                    </div>
                    <p style="color: white; padding-left: 15px;">
                        <br>
                <a style="color:white;" href="forgot_password.php">Forgot password?</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    New to this website? <a style="color:white;" href="sign_up.php">Sign Up</a>

                    </p>
                </form>
            </div>
        </div>
    </center>
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
