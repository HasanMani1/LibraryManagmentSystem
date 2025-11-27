<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/library-09.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;   
            align-items: center;        
            min-height: 100vh;          
        }

        .form-container {
            background: rgba(255,255,255,0.85);
            padding: 25px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Event Feedback Form</h2>
    <form action="event_feedback.php" method="POST">

        <label for="event_name">Event Name</label>
        <input type="text" id="event_name" name="event_name" required>

        <label for="rating">Overall Rating</label>
        <select id="rating" name="rating" required>
            <option value="">-- Select Rating --</option>
            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
            <option value="4">⭐⭐⭐⭐ Good</option>
            <option value="3">⭐⭐⭐ Average</option>
            <option value="2">⭐⭐ Poor</option>
            <option value="1">⭐ Very Poor</option>
        </select>

        <label for="comments">Comments / Suggestions</label>
        <textarea id="comments" name="comments" rows="4" placeholder="Your thoughts…" required></textarea>

        <label for="email">Your Email (Optional)</label>
        <input type="email" id="email" name="email">

        <button type="submit">Submit Feedback</button>
    </form>
</div>

</body>
</html>
