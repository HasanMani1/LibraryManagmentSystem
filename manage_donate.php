<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';
include 'notification_helper.php';

/* =========================
   ACCESS CONTROL
   ========================= */
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [1, 2])) {
    header("Location: access_denied.php");
    exit;
}

$approver_id = $_SESSION['user_id'];

/* =========================
   APPROVE DONATION
   ========================= */
if (isset($_POST['approve'])) {
    $donation_id = (int) $_POST['donation_id'];

    $stmt = $conn->prepare("
        SELECT bd.book_title, bd.donor_id
        FROM book_donation bd
        WHERE bd.donation_id = ? AND bd.status = 'Pending'
    ");
    $stmt->bind_param("i", $donation_id);
    $stmt->execute();
    $donation = $stmt->get_result()->fetch_assoc();

    if ($donation) {

        // Insert donated book
        $insertBook = $conn->prepare("
            INSERT INTO book (title, book_type, category_id)
            VALUES (?, 'Donated', 1)
        ");
        $insertBook->bind_param("s", $donation['book_title']);
        $insertBook->execute();

        // Update donation status
        $update = $conn->prepare("
            UPDATE book_donation
            SET status = 'Approved',
                is_approved = 1,
                approver_id = ?,
                approved_date = NOW()
            WHERE donation_id = ?
        ");
        $update->bind_param("ii", $approver_id, $donation_id);
        $update->execute();

        // 🔔 Notify donor
        createNotification(
            $donation['donor_id'],
            "Book Donation Approved",
            "Thank you! Your donated book '{$donation['book_title']}' has been approved and added to the library."
        );

        logActivity($approver_id, "Approved donation ID $donation_id");

        header("Location: manage_donate.php?success=approved");
        exit;
    }
}

/* =========================
   REJECT DONATION
   ========================= */
if (isset($_POST['reject'])) {
    $donation_id = (int) $_POST['donation_id'];

    $stmt = $conn->prepare("
        SELECT donor_id, book_title
        FROM book_donation
        WHERE donation_id = ? AND status = 'Pending'
    ");
    $stmt->bind_param("i", $donation_id);
    $stmt->execute();
    $donation = $stmt->get_result()->fetch_assoc();

    if ($donation) {

        $update = $conn->prepare("
            UPDATE book_donation
            SET status = 'Rejected',
                is_approved = 0,
                approver_id = ?,
                approved_date = NOW()
            WHERE donation_id = ?
        ");
        $update->bind_param("ii", $approver_id, $donation_id);
        $update->execute();

        // 🔔 Notify donor
        createNotification(
            $donation['donor_id'],
            "Book Donation Rejected",
            "Your donated book '{$donation['book_title']}' was rejected. Please contact the library for details."
        );

        logActivity($approver_id, "Rejected donation ID $donation_id");

        header("Location: manage_donate.php?success=rejected");
        exit;
    }
}

/* =========================
   FETCH DONATIONS
   ========================= */
$donations = $conn->query("
    SELECT 
        bd.donation_id,
        bd.book_title,
        bd.status,
        bd.approved_date,
        u.name AS donor_name,
        a.name AS approver_name
    FROM book_donation bd
    LEFT JOIN user u ON bd.donor_id = u.user_id
    LEFT JOIN user a ON bd.approver_id = a.user_id
    ORDER BY bd.donation_id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Book Donations</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
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
        .back-btn i { font-size: 18px; }

        .container{
                border: 2px solid #94a3b8;
        }
    </style>
</style>
</head>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Manage Book Donations</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center">
            Donation <?= htmlspecialchars($_GET['success']) ?> successfully.
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Donor</th>
            <th>Status</th>
            <th>Approved By</th>
            <th>Approved Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        <?php if ($donations->num_rows === 0): ?>
            <tr><td colspan="7">No donations found.</td></tr>
        <?php else: ?>
            <?php while ($d = $donations->fetch_assoc()): ?>
            <tr>
                <td><?= $d['donation_id'] ?></td>
                <td><?= htmlspecialchars($d['book_title']) ?></td>
                <td><?= htmlspecialchars($d['donor_name']) ?></td>
                <td>
                    <span class="badge <?= 
                        $d['status'] === 'Approved' ? 'bg-success' :
                        ($d['status'] === 'Rejected' ? 'bg-danger' : 'bg-warning') ?>">
                        <?= $d['status'] ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($d['approver_name'] ?? '-') ?></td>
                <td><?= $d['approved_date'] ?? '-' ?></td>
                <td>
                    <?php if ($d['status'] === 'Pending'): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="donation_id" value="<?= $d['donation_id'] ?>">
                            <button name="approve" class="btn btn-success btn-sm"
                                    onclick="return confirm('Approve this donation?')">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="donation_id" value="<?= $d['donation_id'] ?>">
                            <button name="reject" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Reject this donation?')">
                                <i class="bi bi-x"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        —
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
