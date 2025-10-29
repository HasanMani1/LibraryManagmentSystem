<?php
session_start();
include 'db_connect.php';
$timeout_duration = 900; // 15 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: user_login.php?session=expired");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Restrict access: only admins (role_id = 1)
if ($_SESSION['role_id'] != 1) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name'];

// ✅ Fetch counts for summary boxes
$counts = [
    'total_users' => 0,
    'admins' => 0,
    'librarians' => 0,
    'teachers' => 0,
    'students' => 0
];

$sql_total = "SELECT COUNT(*) AS total FROM user";
$sql_admins = "SELECT COUNT(*) AS total FROM user WHERE role_id = 1";
$sql_librarians = "SELECT COUNT(*) AS total FROM user WHERE role_id = 2";
$sql_teachers = "SELECT COUNT(*) AS total FROM user WHERE role_id = 3";
$sql_students = "SELECT COUNT(*) AS total FROM user WHERE role_id = 4";

$counts['total_users'] = $conn->query($sql_total)->fetch_assoc()['total'];
$counts['admins'] = $conn->query($sql_admins)->fetch_assoc()['total'];
$counts['librarians'] = $conn->query($sql_librarians)->fetch_assoc()['total'];
$counts['teachers'] = $conn->query($sql_teachers)->fetch_assoc()['total'];
$counts['students'] = $conn->query($sql_students)->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            background-image: url('images/library-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

   .summary-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 18px;
    margin: 25px auto;
    width: 80%;
}

.summary-box {
    width: 160px;
    border-radius: 12px;
    text-align: center;
    padding: 15px;
    color: white;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(0,0,0,0.25);
    transition: all 0.3s ease;
}

.summary-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.35);
}

.summary-box i {
    font-size: 22px;
    margin-bottom: 5px;
}

.summary-box h4 {
    font-size: 16px;
    margin: 5px 0;
}

.summary-box p {
    font-size: 18px;
    margin: 0;
}

.total { background: linear-gradient(135deg, #fd7e14, #f39c12); }
.admin { background: linear-gradient(135deg, #6f42c1, #9b59b6); }
.librarian { background: linear-gradient(135deg, #17a2b8, #20c997); }
.teacher { background: linear-gradient(135deg, #007bff, #00bfff); }
.student { background: linear-gradient(135deg, #28a745, #34d058); }
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
            <li><a href="home.html">HOME</a></li>
            <li><a href="manage_users.php">MANAGE USERS</a></li>
            <li><a href="add_role.php">MANAGE ROLES</a></li>
            <li><a href="activity_log.php">ACTIVITY LOG</a></li>
            <li><a href="event_proposal.php">EVENTS</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
    </nav>
</header>

<section style="padding: 40px; text-align:center;">

    <h2>👨‍💼 Welcome, <?= htmlspecialchars($name); ?>!</h2>
    <p style="font-size: 18px;">You are logged in as an <strong>Administrator</strong>.</p>

    <!-- ✅ Summary Boxes -->
    <div class="summary-section">
    <div class="summary-box total">
        <i class="bi bi-people"></i>
        <h4>Total Users</h4>
        <p><?= $counts['total_users']; ?></p>
    </div>

    <div class="summary-box admin">
        <i class="bi bi-shield-lock"></i>
        <h4>Admins</h4>
        <p><?= $counts['admins']; ?></p>
    </div>

    <div class="summary-box librarian">
        <i class="bi bi-book"></i>
        <h4>Librarians</h4>
        <p><?= $counts['librarians']; ?></p>
    </div>

    <div class="summary-box teacher">
        <i class="bi bi-person-workspace"></i>
        <h4>Teachers</h4>
        <p><?= $counts['teachers']; ?></p>
    </div>

    <div class="summary-box student">
        <i class="bi bi-mortarboard"></i>
        <h4>Students</h4>
        <p><?= $counts['students']; ?></p>
    </div>
</div>

    <!-- Existing Dashboard Content -->
    <div class="container">
        <div class="card mx-auto mt-4" style="width: 70%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h4 class="card-title">Admin Dashboard</h4>
                <p class="card-text">As an Admin, you have full control over the system:</p>
                <ul style="text-align:left; display:inline-block;">
                    <li>👥 Manage Users and Roles</li>
                    <li>📚 Approve and Manage Book Donations</li>
                    <li>📅 Approve or Reject Events</li>
                    <li>💾 Backup & Restore Database</li>
                    <li>🔍 View Activity Logs and Reports</li>
                </ul>
                <br>
                <a href="register.php" class="btn btn-primary">Add New User</a>
                <a href="add_role.php" class="btn btn-success">Manage Roles</a>
                <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                <a href="activity_log.php" class="btn btn-success">Activity Log</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
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
