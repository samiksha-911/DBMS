<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";
$bulk_students = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($csvFile); // skip header
        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $bulk_students[] = ['name' => $row[0], 'roll_number' => $row[1]];
        }
        fclose($csvFile);
    } elseif (isset($_POST['bulk_submit'])) {
        foreach ($_POST['students'] as $student) {
            $name = $conn->real_escape_string($student['name']);
            $roll = $conn->real_escape_string($student['roll_number']);
            $choice1 = $student['choice1'];
            $choice2 = $student['choice2'];
            $subjects = ["ADA", "AI", "DBMS", $choice1, $choice2];

            $stmt = $conn->prepare("INSERT INTO students (name, roll_number) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $roll);
            if ($stmt->execute()) {
                $student_id = $stmt->insert_id;
                foreach ($subjects as $sub) {
                    $res = $conn->query("SELECT id FROM subjects WHERE name = '$sub'");
                    if ($res && $res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        $sub_id = $row['id'];
                        $insert = $conn->query("INSERT INTO subject_selections (student_id, subject_id) VALUES ($student_id, $sub_id)");
                        if (!$insert) {
                            echo "<p style='color:red;'>Failed to assign subject '$sub' to student ID $student_id: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p style='color:red;'>Subject not found: '$sub'</p>";
                    }
                }
                
                
            }
            $stmt->close();
        }
        $message = "✅ Bulk students added successfully with electives.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bulk Add Students</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
        }
        .container {
            width: 90%; max-width: 1100px;
            margin: auto; padding: 40px;
            background: white;
            border-radius: 12px;
            margin-top: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #2c3e50; }
        form { margin-top: 30px; }
        input[type="file"] {
            margin-bottom: 20px;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        th, td {
            padding: 12px; border: 1px solid #ccc;
            text-align: center;
        }
        select, input[type="submit"] {
            padding: 10px; border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        input[type="submit"] {
            background: #3498db; color: white;
            font-weight: bold; cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background: #2980b9;
        }
        .message {
            margin-top: 20px;
            color: green;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bulk Add Students via CSV</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <?php if (empty($bulk_students)): ?>
        <form method="post" enctype="multipart/form-data">
            <label>Select CSV file (Name, Roll No):</label><br>
            <input type="file" name="csv_file" accept=".csv" required><br><br>
            <input type="submit" value="Upload CSV">
        </form>
    <?php else: ?>
        <form method="post">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Roll No</th>
                    <th>Compulsory Subjects</th>
                    <th>Elective 1 (OT/DMS)</th>
                    <th>Elective 2 (MongoDB/MERN)</th>
                </tr>
                <?php foreach ($bulk_students as $index => $student): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($student['name']) ?>
                            <input type="hidden" name="students[<?= $index ?>][name]" value="<?= htmlspecialchars($student['name']) ?>">
                        </td>
                        <td>
                            <?= htmlspecialchars($student['roll_number']) ?>
                            <input type="hidden" name="students[<?= $index ?>][roll_number]" value="<?= htmlspecialchars($student['roll_number']) ?>">
                        </td>
                        <td>ADA, AI, DBMS</td>
                        <td>
                            <select name="students[<?= $index ?>][choice1]" required>
                                <option value="">Select</option>
                                <option value="OT">OT</option>
                                <option value="DMS">DMS</option>
                            </select>
                        </td>
                        <td>
                            <select name="students[<?= $index ?>][choice2]" required>
                                <option value="">Select</option>
                                <option value="MongoDB">MongoDB</option>
                                <option value="MERN">MERN</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <input type="submit" name="bulk_submit" value="Add All Students">
        </form>
    <?php endif; ?>
    <h3 style="margin-top: 40px;">Subject Assignment Overview</h3>
<table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-top: 10px; border-collapse: collapse;">
    <tr style="background-color:#f0f0f0;">
        <th>Name</th>
        <th>Roll No</th>
        <th>Subjects Assigned</th>
    </tr>
    <?php
    $result = $conn->query("
        SELECT s.name, s.roll_number, COUNT(ss.subject_id) as subject_count
        FROM students s
        LEFT JOIN subject_selections ss ON s.id = ss.student_id
        GROUP BY s.id
        ORDER BY s.name
    ");

    while ($row = $result->fetch_assoc()) {
        $bg = $row['subject_count'] < 5 ? 'style="background-color: #ffe5e5;"' : '';
        echo "<tr $bg>
            <td>{$row['name']}</td>
            <td>{$row['roll_number']}</td>
            <td>{$row['subject_count']} / 5</td>
        </tr>";
    }
    ?>
</table>
</div>
</body>
</html>

