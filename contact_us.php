<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';
include 'back_button.php';

$user_id = $_SESSION['user_id'] ?? null;
$name = $_SESSION['name'] ?? '';
$email = $_SESSION['email'] ?? '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare(
        "INSERT INTO contact_message (user_id, name, email, subject, message)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);
    $stmt->execute();

    if ($user_id) {
        logActivity($user_id, "Sent a contact message");
    }

    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Layout for footer */
        body {
            background-size: cover;

            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;

            padding-top: 120px;
        }

        .main-content {
            flex: 1;
        }

        /* Back button (unchanged) */
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

        .form-box {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
               border: 2px solid #94a3b8;
        }

.form-control{
       border: 2px solid #94a3b8;
}
    </style>
</head>

<body>

    <div class="main-content">

        <div class="form-box">
            <h3>📩 Contact Us</h3>

            <?php if ($success): ?>
                <div class="alert alert-success">✅ Message sent successfully!</div>
            <?php endif; ?>

            <form method="POST">
                <input class="form-control mb-2" name="name" placeholder="Your Name" required value="<?= htmlspecialchars($name) ?>">
                <input class="form-control mb-2" name="email" type="email" placeholder="Your Email" required value="<?= htmlspecialchars($email) ?>">
                <input class="form-control mb-2" name="subject" placeholder="Subject" required>
                <textarea class="form-control mb-2" name="message" rows="5" placeholder="Message" required></textarea>
                <button class="btn btn-primary">Send Message</button>
            </form>
        </div>

    </div>


</body>

</html>