<?php
session_start();
include 'db_connect.php'; 
include 'notification_helper.php';
include 'back_button.php';

$ADMIN_USER_ID = 1;
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
            createNotification(
            $ADMIN_USER_ID,
            "New Event Proposal Submitted",
            "A new event proposal titled '{$title}' has been submitted and is awaiting approval."
        );

        echo "<script>alert('🎉 Event proposal submitted successfully! Awaiting approval.');</script>";
        echo "<script>window.location.href='librarian_dashboard.php';</script>";
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
                   border: 2px solid #94a3b8;
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
        .form-control{
                   border: 2px solid #94a3b8;
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
