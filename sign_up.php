<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    // ✅ Restrict to EMU emails only
    if (!preg_match('/@emu\.edu\.tr$/', $email)) {
        $message = "<div class='alert alert-danger'>❌ Only EMU email addresses are allowed for registration.</div>";
        $redirect = false;
    } else {
        // ✅ Role detection (numbers → student, letters → teacher)
        if (preg_match('/^[0-9]/', $email)) {
            $role_id = 4; // Student
        } else {
            $role_id = 3; // Teacher
        }

        // ✅ Duplicate email check
        $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $message = "<div class='alert alert-warning'>⚠️ This email is already registered.</div>";
            $redirect = false;
        } else {
            // ✅ Insert user
            $stmt = $conn->prepare("INSERT INTO user (name, email, password, role_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $email, $hashed_password, $role_id);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>✅ Registration successful! Redirecting to login in 3 seconds...</div>";
               logActivity($_SESSION['user_id'], "User Registered");

                $redirect = true;
            } else {
                $message = "<div class='alert alert-danger'>❌ Error: " . $conn->error . "</div>";
                $redirect = false;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/footer.css">
    <?php if (!empty($redirect) && $redirect === true): ?>
        <meta http-equiv="refresh" content="3;url=user_login.php">
    <?php endif; ?>
    <style>
        html, body {
    height: 100%;
    margin: 0;
    overflow: hidden; /* 🔥 removes scrollbar */
}
        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            flex-direction: column;
              height: 800px;

    margin: 0px;
    background-image: url("images/library-09.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
        }

        .signup-form {
            background-color: rgba(255, 255, 255, 0.96);
            width: 400px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-align: center;
        }

        .signup-form h3 {
            margin-bottom: 25px;
            font-weight: 600;
            color: #003366;
        }

        .signup-form input {
            margin-bottom: 15px;
            border-radius: 8px;
              border: 2px solid #94a3b8;

        }

        .signup-form .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background: linear-gradient(135deg, #0056b3, #007bff);
            border: none;
            font-weight: 600;
        }

        .signup-form .btn-primary:hover {
            background: linear-gradient(135deg, #004080, #0056b3);
        }

        .alert {
            width: 400px;
            margin: 15px auto;
            text-align: center;
            border-radius: 8px;
        }

        footer {
            background-color: #002147;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body class="login-page">

<header>
    <div class="logo">
        <img src="images/emu-dau-logo.png" alt="EMU Logo">
        <div class="head">
            <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
          
        </div>
    </div>


</header>

<section>
    <div class="signup-container">
        <div class="signup-form">
            <h3>Sign Up Form</h3>

            <?php if (!empty($message)) echo $message; ?>

            <form method="POST">
                <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                <input class="form-control" type="email" name="email" placeholder="EMU Email Address" required>
                <input class="form-control" type="password" name="password" placeholder="Password" required>
                <input class="btn btn-primary" type="submit" value="Sign Up">
                <p style="margin-top:15px;">Already have an account? <a href="user_login.php" style="color:#007bff;">Login Here</a></p>
            </form>
        </div>
    </div>
</section>


<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-left">
            <p>
                Email: library@emu.edu.tr<br>
                Tel: +90 392 630 xxxx<br>
                Fax: +90 392 630 xxxx
            </p>
        </div>

        <div class="footer-center">
            © <?php echo date("Y"); ?> Eastern Mediterranean University Library
        </div>

        <div class="footer-right">
            <a href="https://students.emu.edu.tr/" target="_blank">
                students.emu.edu.tr
            </a>
        </div>

    </div>
</footer>
</body>
</html>
