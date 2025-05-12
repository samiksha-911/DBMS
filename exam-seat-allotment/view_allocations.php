<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get subject ID from URL
$subject_id = $_GET['subject_id'] ?? null;
if (!$subject_id) die("Subject ID missing!");

// Get subject name
$subject = $conn->query("SELECT name FROM subjects WHERE id = $subject_id")->fetch_assoc();
echo "<h2>Seating Arrangement for Subject: <u>{$subject['name']}</u></h2>";

// Get all rooms used in this subject's allotment
$rooms = $conn->query("
    SELECT DISTINCT r.* FROM rooms r
    JOIN seat_allotments sa ON r.id = sa.room_id
    WHERE sa.subject_id = $subject_id
");

while ($room = $rooms->fetch_assoc()) {
    echo "<h3>Room: {$room['room_number']} (Floor: {$room['floor']})</h3>";
    echo "<table border='1' cellpadding='10'>";

    // Get students assigned in this room for this subject
    $students = $conn->query("
        SELECT sa.column_number, sa.seat_number, s.roll_number, s.name
        FROM seat_allotments sa
        JOIN students s ON sa.student_id = s.id
        WHERE sa.subject_id = $subject_id AND sa.room_id = {$room['id']}
        ORDER BY sa.column_number, sa.seat_number
    ");

    // Build 2D array: [column][seat] = "Roll - Name"
    $layout = [];
    while ($s = $students->fetch_assoc()) {
        $col = $s['column_number'];
        $seat = $s['seat_number'];
        $layout[$col][$seat] = $s['roll_number'] . " - " . $s['name'];
    }

    // Print layout
    for ($s = 1; $s <= $room['seats_per_column']; $s++) {
        echo "<tr>";
        for ($c = 1; $c <= $room['columns']; $c++) {
            $value = $layout[$c][$s] ?? "-";
            echo "<td><b>C$c-S$s</b><br>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table><br>";
}
?><?php
// DB connection
$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get subject ID from URL
$subject_id = $_GET['subject_id'] ?? null;
if (!$subject_id) die("Subject ID missing!");

// Get subject name
$subject = $conn->query("SELECT name FROM subjects WHERE id = $subject_id")->fetch_assoc();
echo "<h2>Seating Arrangement for Subject: <u>{$subject['name']}</u></h2>";

// Get all rooms used in this subject's allotment
$rooms = $conn->query("
    SELECT DISTINCT r.* FROM rooms r
    JOIN seat_allotments sa ON r.id = sa.room_id
    WHERE sa.subject_id = $subject_id
");

while ($room = $rooms->fetch_assoc()) {
    echo "<h3>Room: {$room['room_number']} (Floor: {$room['floor']})</h3>";
    echo "<table border='1' cellpadding='10'>";

    // Get students assigned in this room for this subject
    $students = $conn->query("
        SELECT sa.column_number, sa.seat_number, s.roll_number, s.name
        FROM seat_allotments sa
        JOIN students s ON sa.student_id = s.id
        WHERE sa.subject_id = $subject_id AND sa.room_id = {$room['id']}
        ORDER BY sa.column_number, sa.seat_number
    ");

    // Build 2D array: [column][seat] = "Roll - Name"
    $layout = [];
    while ($s = $students->fetch_assoc()) {
        $col = $s['column_number'];
        $seat = $s['seat_number'];
        $layout[$col][$seat] = $s['roll_number'] . " - " . $s['name'];
    }

    // Print layout
    for ($s = 1; $s <= $room['seats_per_column']; $s++) {
        echo "<tr>";
        for ($c = 1; $c <= $room['columns']; $c++) {
            $value = $layout[$c][$s] ?? "-";
            echo "<td><b>C$c-S$s</b><br>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table><br>";
}
?>

