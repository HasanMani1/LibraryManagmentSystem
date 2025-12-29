<?php
session_start();
include 'db_connect.php';
include 'log_activity.php';
include 'back_button.php';


// Fetch attendance list with event + user info
$sql = "SELECT 
    ea.attendance_id,
    e.title AS event_title,
    u.name AS user_name,
    ea.attended,
    ea.feedback
FROM event_attendance ea
JOIN event e ON ea.event_id = e.event_id
JOIN user u ON ea.user_id = u.user_id
ORDER BY ea.attendance_id DESC
";
$result = $conn->query($sql);
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
           
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            background: rgba(255,255,255,0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        section {
            background: transparent;
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
    border-radius: 50px;
    padding: 10px 18px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    z-index: 1000;
}
               .container {
            border: 2px solid #94a3b8;
            border-radius: 10px;
            padding: 20px;
            background: white;
        }

</style>
</head>

 <body>  


<section>
    <br>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="text-center flex-grow-1 mb-0">Event Attendance List</h2>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Event Title</th>
                    <th>Participant</th>
                    <th>Attendance</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['attendance_id'] ?></td>
                            <td><?= htmlspecialchars($row['event_title']) ?></td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td>
                                <?php if ($row['attended']): ?>
                                    <span class="badge bg-success">Attended</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not Attended</span>
                                <?php endif; ?>
                            </td>
                            
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5"><em>No attendance records found.</em></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>
