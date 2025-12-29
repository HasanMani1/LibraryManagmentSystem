<?php
include 'db_connect.php';
include 'back_button.php'; 
include 'log_activity.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_name = trim($_POST['role_name']);

    if (!empty($role_name)) {
        $stmt = $conn->prepare("INSERT INTO role (role_name) VALUES (?)");
        $stmt->bind_param("s", $role_name);

        if ($stmt->execute()) {
            echo "<div class='alert success'>✅ Role added successfully!</div>";
            logActivity($_SESSION['user_id'], "Role Added");
        } else {
            echo "<div class='alert error'>❌ Error adding role: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert warning'>⚠️ Please enter a role name.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>
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

        /* Centered form styling */
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        form {
            background: #ffffff;
            width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        h3 {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
                border: 2px solid #94a3b8;
        }

        button {
            background: linear-gradient(135deg, #007bff, #00bfff);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease-in-out;
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
        .event-card {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
             border: 2px solid #94a3b8;
        }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .warning { background-color: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<!-- Your form -->
<form class="event-card" method="POST">
    <h3>Add New Role</h3>
    <input type="text" name="role_name" placeholder="Enter role name" required>
    <button type="submit">Add Role</button>
</form>

</body>
</html>
