<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';
include 'notification_helper.php';
include 'back_button.php';

// ==========================
// APPROVE EVENT PROPOSAL
// ==========================
if (isset($_GET['approve_id'])) {
    $proposal_id = intval($_GET['approve_id']);

    // 1️⃣ Fetch proposal details
    $stmt = $conn->prepare(
        "SELECT title, description, capacity, proposed_by
         FROM event_proposal
         WHERE proposal_id = ?"
    );
    $stmt->bind_param("i", $proposal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proposal = $result->fetch_assoc();
    $stmt->close();

    if ($proposal) {

        // 2️⃣ Insert into event table
        $stmt = $conn->prepare(
            "INSERT INTO event (title, description, capacity)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param(
            "ssi",
            $proposal['title'],
            $proposal['description'],
            $proposal['capacity']
        );
        $stmt->execute();
        $new_event_id = $stmt->insert_id;
        $stmt->close();

        // 3️⃣ Update proposal status
        $stmt = $conn->prepare(
            "UPDATE event_proposal
             SET status = 'Approved', event_id = ?, created_at = NOW()
             WHERE proposal_id = ?"
        );
        $stmt->bind_param("ii", $new_event_id, $proposal_id);
        $stmt->execute();
        $stmt->close();

        // 🔔 4️⃣ Notify ONLY the teacher who proposed the event
        createNotification(
            $proposal['proposed_by'],
            "Approved Library Event",
            "Your proposed library event '{$proposal['title']}' has been approved."
        );

        echo "<script>
            alert('✅ Event approved and teacher notified.');
            window.location='event_proposal.php';
        </script>";
        exit;
    }
}

// ==========================
// REJECT EVENT PROPOSAL
// ==========================
// ==========================
// REJECT EVENT PROPOSAL
// ==========================
if (isset($_GET['reject_id'])) {
    $proposal_id = intval($_GET['reject_id']);

    // 1️⃣ Fetch proposal info
    $stmt = $conn->prepare(
        "SELECT title, proposed_by
         FROM event_proposal
         WHERE proposal_id = ?"
    );
    $stmt->bind_param("i", $proposal_id);
    $stmt->execute();
    $proposal = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($proposal) {

        // 2️⃣ Update status
        $stmt = $conn->prepare(
            "UPDATE event_proposal
             SET status = 'Rejected'
             WHERE proposal_id = ?"
        );
        $stmt->bind_param("i", $proposal_id);
        $stmt->execute();
        $stmt->close();

        // 🔔 3️⃣ Notify the teacher
        createNotification(
            $proposal['proposed_by'],
            "Event Proposal Rejected",
            "Your event proposal '{$proposal['title']}' has been rejected."
        );
    }

    echo "<script>
        alert('❌ Event proposal rejected and teacher notified.');
        window.location='event_proposal.php';
    </script>";
    exit;
}

// ==========================
// FETCH ALL PROPOSALS
// ==========================
$result = $conn->query(
    "SELECT * FROM event_proposal ORDER BY proposal_id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Proposals</title>

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
body {
   
    background-size: cover;
    background-attachment: fixed;
}

.container {
    margin-top: 40px;
    background: rgba(255,255,255,0.9);
    padding: 30px;
    border-radius: 10px;
        border: 2px solid #94a3b8;
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

</style>
</head>

<body>

<div class="container">
<h2 class="text-center mb-4">Event Proposals</h2>

<table class="table table-bordered text-center">
<thead class="table-primary">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Capacity</th>
    <th>Proposed By</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['proposal_id']; ?></td>
    <td><?= htmlspecialchars($row['title']); ?></td>
    <td><?= htmlspecialchars($row['description']); ?></td>
    <td><?= $row['capacity']; ?></td>
    <td><?= htmlspecialchars($row['proposed_by']); ?></td>
    <td>
        <?php if ($row['status'] === 'Approved'): ?>
            <span class="badge bg-success">Approved</span>
        <?php elseif ($row['status'] === 'Rejected'): ?>
            <span class="badge bg-danger">Rejected</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Pending</span>
        <?php endif; ?>
    </td>
    <td>
        <?php if ($row['status'] === 'Pending'): ?>
            <a href="?approve_id=<?= $row['proposal_id']; ?>" class="btn btn-success btn-sm">Approve</a>
            <a href="?reject_id=<?= $row['proposal_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</body>
</html>
