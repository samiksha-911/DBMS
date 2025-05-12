<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $floor = $_POST["floor_number"];
    $room_no = $_POST["room_number"];
    $columns = $_POST["columns"];
    $seats_per_column = $_POST["seats_per_column"];

    $stmt = $conn->prepare("INSERT INTO rooms (floor_number, room_number, columns, seats_per_column) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $floor, $room_no, $columns, $seats_per_column);
    if ($stmt->execute()) {
        $message = "✅ Room added successfully.";
    } else {
        $message = "❌ Failed to add room.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f8f9fa, #e0eafc);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: white;
            border-radius: 16px;
            padding: 40px 50px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            color: #2d3436;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #f9f9f9;
        }
        input[type="submit"] {
            width: 100%;
            padding: 14px;
            margin-top: 30px;
            background: linear-gradient(to right, #00b09b, #96c93d);
            color: white;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            opacity: 0.95;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add Exam Room</h2>
    <form method="post">
        <label for="floor">Floor:</label>
        <input type="text" name="floor" id="floor" required>

        <label for="room_no">Room No:</label>
        <input type="text" name="room_no" id="room_no" required>

        <label for="columns">Number of Columns:</label>
        <input type="number" name="columns" id="columns" min="1" required>

        <label for="seats_per_column">Seats per Column:</label>
        <input type="number" name="seats_per_column" id="seats_per_column" min="1" required>

        <input type="submit" value="Add Room">
    </form>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</div>
</body>
</html>
