<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';

// 🔐 Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: user_login.php");
    exit;
}

// ✅ Handle approve/reject actions
if (isset($_GET['approve'])) {
    $donation_id = intval($_GET['approve']);
    $approver_id = $_SESSION['user_id'];
    $conn->query("UPDATE book_donation 
                  SET is_approved = 1, status = 'Approved', approver_id = $approver_id, approved_date = NOW()
                  WHERE donation_id = $donation_id");
    logActivity($approver_id, "Approved donation ID: $donation_id");
    header("Location: manage_donate.php?success=1");
    exit;
}

if (isset($_GET['reject'])) {
    $donation_id = intval($_GET['reject']);
    $approver_id = $_SESSION['user_id'];
    $conn->query("UPDATE book_donation 
                  SET is_approved = 0, status = 'Rejected', approver_id = $approver_id, approved_date = NOW()
                  WHERE donation_id = $donation_id");
    logActivity($approver_id, "Rejected donation ID: $donation_id");
    header("Location: manage_donate.php?success=1");
    exit;
}

// Fetch all donations
$donations = $conn->query("
    SELECT bd.*, u.username AS donor_name, a.username AS approver_name
    FROM book_donation bd
    LEFT JOIN users u ON bd.donor_id = u.user_id
    LEFT JOIN users a ON bd.approver_id = a.user_id
    ORDER BY bd.donation_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Book Donations</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body { font-family: Arial, sans-serif; background: #f4f6f9; margin:0; padding:0; }
.container { width: 95%; margin: 80px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);}
h2 { text-align: center; color: #007bff; margin-bottom: 25px; }

table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
th { background-color: #007bff; color: white; }
tr:hover { background-color: #f2f2f2; }

.btn { padding: 5px 10px; border-radius: 5px; color: white; text-decoration: none; display: inline-block; margin: 2px; }
.btn-approve { background: #28a745; }
.btn-reject { background: #dc3545; }
.btn-approve:hover, .btn-reject:hover { opacity: 0.85; }

.alert-success { background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center; }

.back-btn { display: inline-block; margin-bottom: 15px; padding: 6px 12px; background: #007bff; color: white; border-radius: 5px; text-decoration: none; }
.back-btn:hover { background: #0056b3; }
</style>
</head>
<body>

<div class="container">
    <a href="admin_dashboard.php" class="back-btn">← Back</a>
    <h2>📚 Manage Book Donations</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">Action completed successfully!</div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Book Title</th>
                <th>Donor</th>
                <th>Status</th>
                <th>Approver</th>
                <th>Approved Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($donations->num_rows === 0): ?>
            <tr><td colspan="7">No donations found.</td></tr>
        <?php else: ?>
            <?php while($d = $donations->fetch_assoc()): ?>
            <tr>
                <td><?= $d['donation_id']; ?></td>
                <td><?= htmlspecialchars($d['book_title']); ?></td>
                <td><?= htmlspecialchars($d['donor_name']); ?></td>
                <td><?= htmlspecialchars($d['status']); ?></td>
                <td><?= htmlspecialchars($d['approver_name'] ?: '-'); ?></td>
                <td><?= $d['approved_date'] ?: '-'; ?></td>
                <td>
                    <?php if ($d['status'] === 'Pending'): ?>
                        <a href="manage_donate.php?approve=<?= $d['donation_id']; ?>" class="btn btn-approve">Approve</a>
                        <a href="manage_donate.php?reject=<?= $d['donation_id']; ?>" class="btn btn-reject">Reject</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
