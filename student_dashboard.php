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

include 'db_connect.php';


// ✅ Fetch recommended books for dashboard
$sqlRecs = "
    SELECT 
        b.book_id,
        b.title,
        b.author,
        u.name AS teacher_name
    FROM recommendation r
    JOIN book b ON r.book_id = b.book_id
    JOIN user u ON r.suggested_by = u.user_id
    WHERE r.display_on_dashboard = 1
    ORDER BY r.rec_id DESC
    LIMIT 4
";
$recResult = $conn->query($sqlRecs);


// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: student_login.php");
    exit;
}

// ✅ Restrict access: only students (role_id = 4)
if ($_SESSION['role_id'] != 4) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>

    <!-- Existing CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Footer CSS -->
    <link rel="stylesheet" href="css/footer.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background-image: url('images/library-books.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
    }

    section {
        background: transparent;
    }

    h2 {
        display: inline-block;
        padding: 12px 25px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 12px;
        color: white;
        font-weight: bold;
    }

    /* Hover dropdowns */
    .navbar .dropdown:hover > .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    .navbar {
        position: relative;
        z-index: 1000;
    }

    .dropdown-menu {
        max-height: 350px;
        overflow-y: auto;
    }

    .custom-navbar .dropdown-menu {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        padding: 6px 0;
        min-width: 200px;
        overflow: auto;
         min-width: 220px;          /* ensure enough width */
    max-width: 260px;
      text-align: left;
          overflow-x: hidden;

    }

    .custom-navbar .dropdown-item {
        display: block;
        width: 100%;
        padding: 8px 16px;
        font-weight: 500;
        font-size: small;
        color: #1f2d3d;
        transition: background 0.15s ease, color 0.15s ease;
        border-radius: 8px;
        box-sizing: border-box;
            white-space: nowrap;  
    }

    .custom-navbar .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.75);
        color: #0b4a8b;
        box-shadow: inset 0 0 0 1px rgba(11, 74, 139, 0.12);
    }

    .navbar .dropdown-menu {
        animation: dropdownFade 0.2s ease-out;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-divider {
        margin: 6px 12px;
        opacity: 0.3;
    }
    /* ===== DASHBOARD CARD ===== */
.dashboard-card {
    width: 75%;
    box-shadow: 0 0 15px rgba(0,0,0,0.15);
    border-radius: 14px;
}

/* Dashboard list */
.dashboard-list {
    text-align: left;
    display: inline-block;
    margin: 0 auto;
    padding-left: 0;
}

.dashboard-list li {
    margin-bottom: 6px;
}

/* Events inside dashboard card */
.events-inside-card {
    margin-top: 10px;
}

.event-row {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 12px;
    background: #f9fafb;
    text-align: left;
}

.event-title {
    font-weight: 700;
    color: #024187;
    margin-bottom: 4px;
}

.event-desc {
    font-size: 0.9rem;
    margin-bottom: 6px;
    color: #374151;
}

.event-capacity {
    font-size: 0.8rem;
    font-weight: 600;
    color: #024187;
}

</style>

<body>

<header>
    <div class="logo">
        <img src="images/emu-dau-logo.png" alt="EMU Logo">
        <div class="head">
            <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#studentNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="studentNavbar">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Events</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="final_event_list.php">Upcoming Events</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Books</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="book.php">Books</a></li>
                            <li><a class="dropdown-item" href="return_book.php">Return Books</a></li>
                            <li><a class="dropdown-item" href="borrow_history.php">Borrow History</a></li>
                            <li><a class="dropdown-item" href="rate_book.php">Rate Books</a></li>
                            <li><a class="dropdown-item" href="view_book_ratings.php">View Book Ratings</a></li>
                            <li><a class="dropdown-item" href="book_donate.php">Donate Books</a></li>
                            <li><a class="dropdown-item" href="recommended_books.php">Recommended Books</a></li>
                        </ul>
                    </li>
                   <li><a class="nav-link text-transparent" href="wishlist.php">Wishlist</a></li>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Notifications</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="notifications.php">View Notifications</a></li>
                            <li><a class="dropdown-item" href="library_hours.php">Library Hours</a></li>
                            <li><a class="dropdown-item" href="view_capacity.php">Library Capacity</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Contact</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="contact_us.php">Contact Library</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="logout.php">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>

<section style="padding: 40px; text-align:center;">
    <div class="container">
        <h2 style="background:none;border:none">🎓 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <hr>

   <div class="card mx-auto mt-4 dashboard-card">
    <div class="card-body">

        <h4 class="card-title text-center mb-3">
            📖 Recommended by Your Teachers
        </h4>

        <?php if ($recResult && $recResult->num_rows > 0): ?>
            <div class="events-inside-card">
                <?php while ($rec = $recResult->fetch_assoc()): ?>
                    <div class="event-row">
                        <div class="event-title">
                            <?= htmlspecialchars($rec['title']); ?>
                        </div>

                        <div class="event-desc">
                            Author: <?= htmlspecialchars($rec['author']); ?>
                        </div>

                        <div class="event-capacity">
                            Recommended by <?= htmlspecialchars($rec['teacher_name']); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="text-center mt-3">
                <a href="recommended_books.php" class="btn btn-outline-primary btn-sm" style="
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #024187;
            background: transparent;
            color: #024187;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        "
        onmouseover="this.style.background='#024187'; this.style.color='white';"
        onmouseout="this.style.background='transparent'; this.style.color='#024187';">
                    View All Recommendations
                </a>
            </div>

        <?php else: ?>
            <p class="text-muted text-center mb-0">
                No recommendations available yet.
            </p>
        <?php endif; ?>

    </div>
</div>

</div>

    </div>
</section>

<!-- ✅ GLOBAL FOOTER -->
<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-left">
            <p>
                Email: library@emu.edu.tr<br>
                Tel: +90 392 630 xxxx<br>
                Fax: +90 392 630 xxxx
            </p>
        </div>

        <div class="footer-center">
            © <?php echo date("Y"); ?> Eastern Mediterranean University Library
        </div>

        <div class="footer-right">
            <a href="https://students.emu.edu.tr/" target="_blank">
                students.emu.edu.tr
            </a>
        </div>

    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
