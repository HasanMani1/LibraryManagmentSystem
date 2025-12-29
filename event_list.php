<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';


if (isset($_GET['delete'])) {
    $rid = intval($_GET['delete']);
    $sql = "DELETE FROM event WHERE event_id =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rid);

    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully');</script>";
        echo "<script>window.location.href = 'event_list.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to delete event');</script>";
    }
}


$result = $conn->query("SELECT * FROM event ORDER BY event_id DESC");
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
   
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
      
        .header-text { 
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
            color: #141313ff;
        }
        .container {
            width: 90%;
            margin: auto;
            background: rgba(255,255,255,0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border: 2px solid #94a3b8;
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
        



</style>
</head>

 <body>
      
        <section>
             <br>
        <div class="container">
        <div class="header-text">Events</div>

        <table class="table table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['event_id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['capacity'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-2">
                        <a href="event_list.php?delete=<?= $row['event_id'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this event?');">
                            <i class="bi bi-trash"></i> Delete
                         </a>
                                </div>
                        </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
    <br>

   </body>
 </html>
