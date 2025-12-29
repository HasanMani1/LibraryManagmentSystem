<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';
include 'back_button.php';
// 🔐 Admin or Librarian only
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [1, 2])) {
    header("Location: unauthorized.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Update capacity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = intval($_POST['current_occupancy']);

    $stmt = $conn->prepare("
        UPDATE library_capacity
        SET current_occupancy = ?, last_updated = NOW(), updated_by = ?
        WHERE capacity_id = 1
    ");
    $stmt->bind_param("ii", $current, $user_id);
    $stmt->execute();
    $stmt->close();

    logActivity($user_id, "Updated library capacity to $current");
    $message = "Capacity updated successfully.";
}

// Fetch current data
$res = $conn->query("SELECT * FROM library_capacity WHERE capacity_id = 1");
$data = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Library Capacity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
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
        .container{
                border: 2px solid #94a3b8;
        }
        .form-control{
                border: 2px solid #94a3b8;
        }
</style>
<div class="container mt-5">
    <h2 class="text-center mb-4">🏢 Manage Library Capacity</h2>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" class="card p-4">
        <div class="mb-3">
            <label class="form-label">Maximum Capacity</label>
            <input type="number" class="form-control" value="<?= $data['max_capacity'] ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Occupancy</label>
            <input type="number" name="current_occupancy" class="form-control"
                   value="<?= $data['current_occupancy'] ?>" required min="0">
        </div>

        <button class="btn btn-primary">Update Capacity</button>
    </form>
</div>

</body>
</html>
