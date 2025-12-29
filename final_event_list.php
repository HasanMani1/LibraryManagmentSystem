<?php
include 'db_connect.php';
include 'back_button.php';

$sql = "SELECT event_id, title, description, capacity FROM event
        ORDER BY event_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Library Events</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    background-color: white;
    background-size: cover;
    padding-top: 140px;
    font-family: 'Poppins', sans-serif;

    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
}


       .container {
            border: 2px solid #94a3b8;
            border-radius: 10px;
            padding: 20px;
            background: white;
        }

.card {
    border-radius: 14px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.2);
}

.card-title {
    font-weight: 600;
}

.capacity-badge {
    font-size: 0.9rem;
    padding: 8px 12px;
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
    border-radius: 50px;
    padding: 10px 18px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    z-index: 1000;
}

footer {
    width: 100%;
    background-color: #024187;
    color: white;
    padding: 25px 0;
    text-align: center;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="main-content">
    <div class="container">
        <h3 class="mb-4 text-center">📚 Upcoming Library Events</h3>

        <div class="row g-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <a href="event.php?id=<?= $row['event_id'] ?>" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($row['title']) ?>
                                </h5>

                                <p class="card-text flex-grow-1">
                                    <?= htmlspecialchars($row['description']) ?>
                                </p>

                                <span class="badge bg-secondary capacity-badge align-self-start">
                                    Capacity: <?= $row['capacity'] ?>
                                </span>
                            </div>
                        </div>
                </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    No active events at the moment.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



</body>
</html>
