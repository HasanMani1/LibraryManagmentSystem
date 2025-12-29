<?php
session_start();
include 'db_connect.php';
include 'back_button.php';

$res = $conn->query("
    SELECT lc.*, u.name AS updated_by_name
    FROM library_capacity lc
    LEFT JOIN user u ON lc.updated_by = u.user_id
    WHERE capacity_id = 1
");
$data = $res->fetch_assoc();

$isFull = $data['current_occupancy'] >= $data['max_capacity'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Library Capacity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
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
        border-radius: 50px;
        padding: 10px 18px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        z-index: 1000;
    }

    
</style>

<body class="bg-light">

    <div class="main-content">
        <div class="container mt-5 text-center">
            <h2>🏢 Library Capacity Status</h2>

            <div class="card mt-4 p-4">
                <h3 class="<?= $isFull ? 'text-danger' : 'text-success' ?>">
                    <?= $isFull ? '🔴 Library Full' : '🟢 Seats Available' ?>
                </h3>

                <p class="mt-3">
                    <?= $data['current_occupancy'] ?> / <?= $data['max_capacity'] ?> seats occupied
                </p>

                <small class="text-muted">
                    Last updated: <?= $data['last_updated'] ?><br>
                </small>
            </div>
        </div>
    </div>



</body>

</html>