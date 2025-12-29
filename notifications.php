<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Mark as read
if (isset($_GET['read'])) {
    $id = intval($_GET['read']);
    $conn->query(
        "UPDATE notification SET is_read = 1 
         WHERE notification_id = $id AND user_id = $user_id"
    );
}

$result = $conn->query(
    "SELECT * FROM notification 
     WHERE user_id = $user_id 
     ORDER BY created_at DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Layout for sticky footer */
        body {
        
            background-size: cover;

            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;

            padding-top: 140px;
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

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
                border: 2px solid #94a3b8;
        }

        .unread {
            background-color: #f8f9fa;
            font-weight: 600;
            
        }


    </style>
</head>

<body>

<div class="main-content">

    <div class="container">
        <h3>🔔 Notifications</h3>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info">No notifications yet.</div>
        <?php else: ?>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item <?= $row['is_read'] ? '' : 'unread'; ?>">
                        <strong><?= htmlspecialchars($row['title']); ?></strong><br>
                        <?= htmlspecialchars($row['message']); ?><br>
                        <small><?= date("d M Y H:i", strtotime($row['created_at'])); ?></small>

                        <?php if (!$row['is_read']): ?>
                            <a href="?read=<?= $row['notification_id']; ?>" 
                               class="btn btn-sm btn-primary float-end">
                                Mark as read
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>


</body>
</html>
