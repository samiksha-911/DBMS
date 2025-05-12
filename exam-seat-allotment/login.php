<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

// Dummy admin credentials (you can later replace this with DB-based login)
$admin_user = "sam";
$admin_pass = "sam123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type=submit] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>


