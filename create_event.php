<?php
include 'db_connect.php'; // your database connection file
session_start();

// OPTIONAL: automatically get the user proposing the event
// assuming you store username or user_id in $_SESSION
$proposed_by = $_SESSION['user_id'] ?? null;

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $capacity = intval($_POST['capacity']);
    
    // if the form includes a "proposed_by" field manually
    if (empty($proposed_by)) {
        $proposed_by = trim($_POST['proposed_by']);
    }

    // ✅ Insert WITHOUT event_id (it’ll be approved later)
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
</head>
<body class="bg-light p-5">
<div class="container bg-white p-4 rounded shadow-sm" style="max-width:600px;">
    <h3 class="text-center mb-4">Submit a New Event Proposal</h3>
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
