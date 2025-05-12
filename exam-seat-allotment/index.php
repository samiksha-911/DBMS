<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_config.php";
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $_SESSION["admin"] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Admin Login</h2>
<form method="POST">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="password"><br><br>
    <input type="submit" value="Login">
</form>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
