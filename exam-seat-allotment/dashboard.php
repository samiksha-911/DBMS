<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$subjects = $conn->query("SELECT COUNT(*) as count FROM subjects")->fetch_assoc()['count'];
$rooms = $conn->query("SELECT COUNT(*) as count FROM rooms")->fetch_assoc()['count'];
$allocations = $conn->query("SELECT COUNT(*) as count FROM allocations")->fetch_assoc();
$allocations_count = $allocations ? $allocations['count'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e4e9f7;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #2f3542;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .nav {
            background-color: #57606f;
            padding: 10px;
            display: flex;
            gap: 15px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            background-color: #747d8c;
            border-radius: 4px;
        }
        .nav a:hover {
            background-color: #a4b0be;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 30px;
        }
        .card {
            background-color: white;
            padding: 30px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 220px;
            text-align: center;
        }
        .card h2 {
            font-size: 36px;
            color: #2f3542;
        }
        .card p {
            font-size: 16px;
            color: #57606f;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div class="nav">
            <a href="add_student.php">Add Student</a>
            <a href="add_subject.php">Add Subject</a>
            <a href="add_room.php">Add Room</a>
            <a href="view_allocations.php">View Allocations</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2><?= $students ?></h2>
            <p>Registered Students</p>
        </div>
        <div class="card">
            <h2><?= $subjects ?></h2>
            <p>Total Subjects</p>
        </div>
        <div class="card">
            <h2><?= $rooms ?></h2>
            <p>Exam Rooms</p>
        </div>
        <div class="card">
            <h2><?= $allocations_count ?></h2>
            <p>Seats Allotted</p>
        </div>
    </div>
</body>
</html>
