<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get subject ID securely
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;
if (!$subject_id) die("Subject ID missing!");

// Clear previous seat allotments for this subject (optional)
$conn->query("DELETE FROM seat_allotments WHERE subject_id = $subject_id");

// Get students for the subject
$studentResult = $conn->prepare("
    SELECT s.id FROM students s
    JOIN subject_selections ss ON s.id = ss.student_id
    WHERE ss.subject_id = ?
");
$studentResult->bind_param("i", $subject_id);
$studentResult->execute();
$students = $studentResult->get_result();

$studentList = [];
while ($row = $students->fetch_assoc()) {
    $studentList[] = $row['id'];
}

// Get all rooms
$rooms = $conn->query("SELECT * FROM rooms ORDER BY id");
$roomData = [];

while ($room = $rooms->fetch_assoc()) {
    $roomSeats = $room['columns'] * $room['seats_per_column'];
    $roomData[] = [
        'room_id' => $room['id'],
        'floor' => $room['floor_number'],
        'room_no' => $room['room_number'],
        'columns' => $room['columns'],
        'seats_per_column' => $room['seats_per_column'],
        'capacity' => $roomSeats
    ];
}

// Allot seats
$i = 0;
$insertStmt = $conn->prepare("
    INSERT INTO seat_allotments (student_id, subject_id, room_id, column_number, seat_number)
    VALUES (?, ?, ?, ?, ?)
");

foreach ($roomData as $room) {
    for ($c = 1; $c <= $room['columns']; $c++) {
        for ($s = 1; $s <= $room['seats_per_column']; $s++) {
            if ($i >= count($studentList)) break 2;

            $student_id = $studentList[$i];
            $insertStmt->bind_param("iiiii", $student_id, $subject_id, $room['room_id'], $c, $s);
            $insertStmt->execute();
            $i++;
        }
    }
}
$insertStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seat Allotment</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f7;
            text-align: center;
            padding: 40px;
        }
        .confirmation {
            background-color: #dff9fb;
            color: #130f40;
            display: inline-block;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            font-size: 20px;
        }
        button {
            margin-top: 30px;
            padding: 12px 24px;
            background: #1abc9c;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #16a085;
        }
    </style>
</head>
<body>
    <div class="confirmation">
        <?php echo "Seat allotment completed for Subject ID: <strong>" . htmlspecialchars($subject_id) . "</strong>."; ?>
    </div>
    <br>
    <button onclick="window.print()">Print Seating Plan</button>
</body>
</html>
