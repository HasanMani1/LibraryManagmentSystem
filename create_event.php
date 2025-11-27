<?php
include 'db_connect.php'; 
session_start();

$proposed_by = $_SESSION['user_id'] ?? null;

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $capacity = intval($_POST['capacity']);
    
    if (empty($proposed_by)) {
        $proposed_by = trim($_POST['proposed_by']);
    }

    $sql = "INSERT INTO event_proposal (title, description, capacity, proposed_by) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssis", $title, $description, $capacity, $proposed_by);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('🎉 Event proposal submitted successfully! Awaiting approval.');</script>";
        echo "<script>window.location.href='event_proposal.php';</script>";
    } else {
        echo "<script>alert('❌ Something went wrong. Please try again.');</script>";
    }

    $stmt->close();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Event Proposal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        background-image: url('images/img_14901_3.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        }


        .event-card {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }


        .header-text {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
        }

        .btn-custom {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light p-5">
    
<div class="event-card" >

    <div class="header-text"> New Event Proposal</div>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Proposed By</label>
            <input type="text" name="proposed_by" class="form-control" 
                value="<?php echo htmlspecialchars($proposed_by ?? ''); ?>" 
                <?php echo isset($_SESSION['user_id']) ? 'readonly' : ''; ?> required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary w-100">Submit Proposal</button>
    </form>
</div>
</body>
</html>
