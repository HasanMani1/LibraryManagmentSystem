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

/* =====================================================
   RESET PASSWORD FORM – FORM ONLY
   ===================================================== */

.reset-wrapper {
    background: #ffffff;
    width: 420px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    text-align: center;
}

/* Title */
.reset-wrapper h3 {
    margin-bottom: 22px;
    font-size: 24px;
    font-weight: 700;
    color: #024187; /* EMU blue */
}

/* Inputs */
/* Inputs – visible borders even when not focused */
.reset-wrapper input {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 8px;

    /* 🔥 stronger default border */
    border: 2px solid #94a3b8;

    font-size: 15px;
    background-color: #ffffff;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

/* Focus state – EMU blue */
.reset-wrapper input:focus {
    outline: none;
    border-color: #024187;
    box-shadow: 0 0 0 3px rgba(2, 65, 135, 0.18);
}


/* Button */
.reset-wrapper button {
    width: 100%;
    background: #024187;
    border: none;
    color: white;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.2s ease;
}

.reset-wrapper button:hover {
    background: #013366;
    transform: translateY(-1px);
}

/* Links inside form */
.reset-wrapper a {
    color: #024187;
    font-weight: 600;
    text-decoration: none;
}

.reset-wrapper a:hover {
    text-decoration: underline;
}

/* Alerts (kept consistent) */
.alert {
    width: 420px;
    margin: 20px auto;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
}

.success {
    background-color: #d4edda;
    color: #155724;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
}
/* ===== CENTER FORM ON PAGE ===== */

body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;   /* horizontal center */
    align-items: center;       /* vertical center */
}


</style>
</head>
<body>

<form method="POST" class="reset-wrapper">
    <h3>Reset Your Password</h3>

    <input type="email" name="email" placeholder="Enter your registered email" required>
    <input type="password" name="new_password" placeholder="Enter new password" required>

    <button type="submit">Reset Password</button>

    <p style="margin-top:15px;">
        Remembered it?
        <a href="user_login.php">Login</a>
    </p>
</form>

</body>

</html>
