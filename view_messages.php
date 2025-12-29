<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

// ✅ Admin only
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: unauthorized.php");
    exit;
}

$result = $conn->query("
    SELECT cm.*, u.name AS user_name
    FROM contact_message cm
    LEFT JOIN user u ON cm.user_id = u.user_id
    ORDER BY cm.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Messages</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {

    background-size: cover;
    background-attachment: fixed;
    padding-top: 140px; /* ✅ pushes content below back button */
    font-family: Arial, sans-serif;
}

.container {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        border: 2px solid #94a3b8;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* ✅ forces equal column alignment */
}

table th, table td {
    padding: 12px;
    text-align: center; /* ✅ align headers and cells */
    vertical-align: middle;}

table th {
    background-color: #007bff;
    color: white;
    font-weight: 600;
}

.message-box {
    text-align: left;       /* message content should be readable */
    word-wrap: break-word;
    white-space: normal;
}
h3 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 600;
}
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

<div class="container">
    <h3>📨 Contact Messages</h3>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">
            No messages have been received yet.
        </div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['subject']); ?></td>
                 <td class="message-box">
    <?= nl2br(htmlspecialchars($row['message'])); ?>
</td>

                    <td><?= date("d M Y H:i", strtotime($row['created_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
