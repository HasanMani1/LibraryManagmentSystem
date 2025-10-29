<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';


// Approve action
if (isset($_GET['approve_id'])) {
    $proposal_id = intval($_GET['approve_id']);

    // 1️⃣ Fetch proposal details
    $query = "SELECT title, description, capacity, proposed_by FROM event_proposal WHERE proposal_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $proposal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proposal = $result->fetch_assoc();

    if ($proposal) {
        // 2️⃣ Insert into event table
        $insert = $conn->prepare("INSERT INTO event (title, description, capacity) VALUES (?, ?, ?)");
        $insert->bind_param("ssi", $proposal['title'], $proposal['description'], $proposal['capacity']);
        $insert->execute();

        $new_event_id = $insert->insert_id;

        // 3️⃣ Update proposal status + link to event_id
        $update = $conn->prepare("UPDATE event_proposal SET status = 'Approved', event_id = ?, created_at = NOW() WHERE proposal_id = ?");
        $update->bind_param("ii", $new_event_id, $proposal_id);
        $update->execute();

        echo "<script>alert('✅ Event approved successfully!'); window.location='event_proposal.php';</script>";
    }
}

// Reject action
if (isset($_GET['reject_id'])) {
    $proposal_id = intval($_GET['reject_id']);
    $stmt = $conn->prepare("UPDATE event_proposal SET status='Rejected' WHERE proposal_id=?");
    $stmt->bind_param("i", $proposal_id);
    $stmt->execute();
    echo "<script>alert('❌ Event proposal rejected.'); window.location='event_proposal.php';</script>";
}

// Fetch all proposals
$result = $conn->query("SELECT * FROM event_proposal ORDER BY proposal_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Approved Events</title>
<link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding-top: 120px;
        }

        .container {
            width: 90%;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
                table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
                .alert-success { background-color: #d4edda; color: #155724; }
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

</style>
</head>

 <body>
        <header>
        <div class="logo">
            <img src="images/emu-dau-logo.png" alt="EMU Logo">
            <div class="head">
                <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
                <h4 style="color: white; padding-left:80px;">ONLINE LIBRARY MANAGEMENT SYSTEM</h4>
                </div>
        </div>
            <nav>
            <ul> 
                <li><a href="admin_dashboard.php">HOME</a></li>
                <li><a href="event_list.php">EVENTS</a></li>
                <li><a href="event_feedback.php">FEEDBACK</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </nav>
        </header>
    <section> 
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="admin_dashboard.php" class="btn btn-secondary back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <h3 class="text-center flex-grow-1 mb-0">Event Proposals</h3>
</div>

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
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['proposal_id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= $row['capacity'] ?></td>
                <td><?= htmlspecialchars($row['proposed_by']) ?></td>
                <td>
                    <?php if ($row['status'] == 'Approved'): ?>
                        <span class="badge bg-success">Approved</span>
                    <?php elseif ($row['status'] == 'Rejected'): ?>
                        <span class="badge bg-danger">Rejected</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <a href="?approve_id=<?= $row['proposal_id'] ?>" class="btn btn-success btn-sm">Approve</a>
                        <a href="?reject_id=<?= $row['proposal_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                    <?php else: ?>
                        <em>N/A</em>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
                    </section>
    <footer>
    <p style="color: white; text-align:center;">
        <br><br>Email: &nbsp;library@emu.edu.tr <br><br>
        Tel: &nbsp;+90 392 630 xxxx <br><br>
        Fax: &nbsp;+90 392 630 xxxx <br><br>
    </p>
</footer>
</body>
</html>
