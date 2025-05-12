<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "exam_seating");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];

    $stmt = $conn->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject_name, $subject_code);
    if ($stmt->execute()) {
        $message = "✅ Subject added successfully.";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f0f2f5, #c9d6ff);
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

        input[type="text"] {
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
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            opacity: 0.9;
        }

        .message {
            margin-top: 25px;
            text-align: center;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add New Subject</h2>
    <form method="post">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" id="subject_name" required>

        <label for="subject_code">Subject Code:</label>
        <input type="text" name="subject_code" id="subject_code" required>

        <input type="submit" value="Add Subject">
    </form>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</div>
</body>
</html>
