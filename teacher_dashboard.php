<?php
session_start();
$timeout_duration = 900; // 15 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: user_login.php?session=expired");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
include 'db_connect.php';
// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

// ✅ Restrict access: only teachers (role_id = 3)
if ($_SESSION['role_id'] != 3) {
    header("Location: unauthorized.php");
    exit;
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="css/footer.css">
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

        /* Keep dropdowns positioned correctly */
        .navbar {
            position: relative;
            z-index: 1000;
        }

        .dropdown-menu {
            max-height: 350px;
            overflow-y: auto;
}
/* Dropdown container – frosted glass */
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
}

/* Make dropdown items full-width blocks */
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
}

/* Uniform hover area */
.custom-navbar .dropdown-item:hover {
    background: rgba(255, 255, 255, 0.75);
    color: #0b4a8b;
    box-shadow: inset 0 0 0 1px rgba(11, 74, 139, 0.12);
}


/* Smooth dropdown appearance */
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
</style>

<header>
    <div class="logo">
        <img src="images/emu-dau-logo.png" alt="EMU Logo">
        <div class="head">
            <h4 style="color: white; padding-left:80px;">EASTERN MEDITERRANEAN UNIVERSITY</h4>
        </div>
    </div>

        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#teacherNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="teacherNavbar">
            <ul class="navbar-nav ms-auto">
 <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Events</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="final_event_list.php">Upcoming Events</a></li>
                        </ul>
                    </li>

                <!-- BOOKS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button">
                        Books
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="book.php">Books</a></li>
                        <li><a class="dropdown-item" href="return_book.php">Return Books</a></li>
                        <li><a class="dropdown-item" href="borrow_history.php">Borrow History</a></li>
                        <li><a class="dropdown-item" href="rate_book.php">Rate Books</a></li>
                        <li><a class="dropdown-item" href="view_book_ratings.php">View Book Ratings</a></li>
                        <li><a class="dropdown-item" href="book_donate.php">Donate Books</a></li>
                        <li><a class="dropdown-item" href="teacher_recommendations.php">Recommended Books</a></li>
                    </ul>
                </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Notifications</a>
                        <ul class="dropdown-menu">
                           
                            <li><a class="dropdown-item" href="library_hours.php">Library Hours</a></li>
                       
                        </ul>
                    </li>
                <!-- WISHLIST -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button">
                        Wishlist
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                    </ul>
                </li>
                <!-- CONTACT -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button">
                        Contact
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="contact_us.php">Contact Library</a></li>
                    </ul>
                </li>

                <!-- SIGN OUT -->
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="logout.php">
                        Logout
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
</header>

<section style="padding: 40px; text-align:center;">
    <div class="container">
        <h2>👩‍🏫 Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <hr>
        <div class="card mx-auto mt-4" style="width: 60%; box-shadow: 0 0 10px #ccc; border-radius:10px;">
            <div class="card-body">
                <h4 class="card-title">Teacher Dashboard</h4>
                <p class="card-text">From here, you can manage your teaching-related activities:</p>
                <ul style="text-align:left; display:inline-block;">
                    <li>Recommend books for your classes 📚</li>
                    <li>View and rate academic resources ⭐</li>
                </ul>
            </div>
        </div>
    </div>
</section>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>