<?php

include 'db_connect.php';
include 'log_activity.php';
session_start();


if (!isset($_GET['id'])) {
    die("No event selected.");
}

$event_id = $_GET['id'];


$sql = "SELECT * FROM event WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found.");
}


if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    $update_sql = "UPDATE event SET title = ?, description = ?, capacity = ? WHERE event_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssii", $title, $description, $capacity, $event_id);

    if ($update_stmt->execute()) {
        header("Location: accepted.php?updated=1");
        exit;
    } else {
        echo "Error updating event.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
            body {
            font-family: Arial, sans-serif;
       
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            background: rgba(255,255,255,0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
               border: 2px solid #94a3b8;
        }
        section {
            background: transparent;
        }
        .form-control{
               border: 2px solid #94a3b8;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Event</h4>
        </div>

        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Event Title</label>
                    <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($event['title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" required value="<?= $event['capacity'] ?>">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" name="update" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Save Changes
                    </button>

                    <a href="accepted.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
