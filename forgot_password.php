<?php
include 'db_connect.php';
include 'back_button.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $update = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_password, $email);
        if ($update->execute()) {
            echo "<div class='alert success'>✅ Password updated successfully! <a href='user_login.php'>Login now</a>.</div>";
        } else {
            echo "<div class='alert error'>❌ Failed to update password.</div>";
        }
    } else {
        echo "<div class='alert error'>⚠️ No account found with that email.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
        /* Back button styling */
        .back-btn {
            position: fixed;
            top: 25px;
            left: 25px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #0056b3, #0080ff);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            color: #f8f9fa;
            text-decoration: none;
        }
        .back-btn i {
            font-size: 18px;
        }
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    padding-top: 120px;
}
form {
    background: #fff;
    width: 400px;
    margin: auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
}
h3 { margin-bottom: 20px; }
input {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
button {
    background: linear-gradient(135deg, #007bff, #00bfff);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}
button:hover {
    background: linear-gradient(135deg, #0056b3, #0080ff);
    transform: scale(1.05);
}
.alert {
    width: 400px;
    margin: 20px auto;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
}
.success { background-color: #d4edda; color: #155724; }
.error { background-color: #f8d7da; color: #721c24; }
</style>
</head>
<body>

<form method="POST">
    <h3>Reset Your Password</h3>
    <input type="email" name="email" placeholder="Enter your registered email" required>
    <input type="password" name="new_password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
    <p style="margin-top:15px;">Remembered it? <a href="user_login.php" style="color:#007bff;">Login</a></p>
</form>

</body>
</html>
