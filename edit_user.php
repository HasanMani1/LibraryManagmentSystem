<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';  

// ✅ Only Admin can access
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: unauthorized.php");
    exit;
}

// ✅ Get user ID
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);

// ✅ Fetch user data
$stmt = $conn->prepare("SELECT user_id, name, email, role_id FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert error'>❌ User not found.</div>";
    exit;
}

$user = $result->fetch_assoc();

// ✅ Fetch all roles for dropdown
$roles = $conn->query("SELECT role_id, role_name FROM role");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role_id = intval($_POST['role_id']);

    if (!empty($name) && !empty($email) && !empty($role_id)) {
        $update = $conn->prepare("UPDATE user SET name = ?, email = ?, role_id = ? WHERE user_id = ?");
        $update->bind_param("ssii", $name, $email, $role_id, $user_id);

        if ($update->execute()) {
            header("Location: manage_users.php?updated=1");
            exit;
        } else {
            echo "<div class='alert error'>❌ Error updating user: " . $conn->error . "</div>";
        }
        $update->close();
    } else {
        echo "<div class='alert warning'>⚠️ Please fill all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding-top: 120px;
        }

        form {
            background: #ffffff;
            width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
                border: 2px solid #94a3b8;
        }

        h3 {
            margin-bottom: 20px;
        }

        input, select {
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

        .error { background-color: #f8d7da; color: #721c24; }
        .warning { background-color: #fff3cd; color: #856404; }
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
    </style>
</head>
<body>

<form method="POST">
    <h3>Edit User Information</h3>

    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" placeholder="Full Name" required>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" placeholder="Email Address" required>

    <select name="role_id" required>
        <option value="" disabled>Select Role</option>
        <?php while ($role = $roles->fetch_assoc()): ?>
            <option value="<?= $role['role_id']; ?>" <?= $role['role_id'] == $user['role_id'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($role['role_name']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Update User</button>
</form>

</body>
</html>
