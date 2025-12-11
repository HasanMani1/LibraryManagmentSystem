<?php
include 'db_connect.php';

$query = "SELECT * FROM library_hours ORDER BY id ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Hours</title>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;
            color: #222;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 25px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
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
                        <td><?= $row['day'] ?></td>

                        <?php if ($row['day'] === "Sunday"): ?>
                            <td colspan="2" class="closed">Closed</td>

                        <?php elseif ($row['open_time'] == "00:00:00" && $row['close_time'] == "00:00:00"): ?>
                            <td colspan="2" class="closed">Closed</td>

                        <?php else: ?>
                            <td><?= date("g:i A", strtotime($row['open_time'])) ?></td>
                            <td><?= date("g:i A", strtotime($row['close_time'])) ?></td>

                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>


    </table>
</div>

</body>
</html>
