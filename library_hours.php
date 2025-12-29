<?php
include 'db_connect.php';
include 'back_button.php';

$query = "SELECT * FROM library_hours ORDER BY id ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Hours</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Layout fix for sticky footer */
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f2f2f2;
            margin: 0;

            display: flex;
            flex-direction: column;
            min-height: 100vh;

            color: #222;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        /* Back button */
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

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 25px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            border: 2px solid #94a3b8;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
               border: 2px solid #94a3b8;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        th {
            background: #444;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .closed {
            color: crimson;
            font-weight: bold;
        }

     
    </style>
</head>

<body>

<div class="main-content">

    <div class="container">
        <h1>Library Hours</h1>

        <table>
            <tr>
                <th>Day</th>
                <th>Opens</th>
                <th>Closes</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['day']); ?></td>

                    <?php if ($row['day'] === "Sunday"): ?>
                        <td colspan="2" class="closed">Closed</td>

                    <?php elseif ($row['open_time'] == "00:00:00" && $row['close_time'] == "00:00:00"): ?>
                        <td colspan="2" class="closed">Closed</td>

                    <?php else: ?>
                        <td><?= date("g:i A", strtotime($row['open_time'])); ?></td>
                        <td><?= date("g:i A", strtotime($row['close_time'])); ?></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>

        </table>
    </div>

</div>



</body>
</html>
