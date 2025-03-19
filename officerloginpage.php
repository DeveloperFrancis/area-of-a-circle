<?php
session_start();
$host = "localhost";
$user = "root"; 
$password = "";
$dbname = "prisoner_regestration_system";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['officername'];
    $password = $_POST['officerpassword'];

    $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE username = ? AND role = 'officer'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $password_hash);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && hash("sha256", $password) === $password_hash) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'officer';
        header("Location: officerhomepage.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #222; text-align: center; color: black; }
        .login-box { background: ghostwhite; width: 30%; padding: 20px; border-radius: 20px; border: ridge black; margin: auto; margin-top: 50px; }
        .login-box input { width: 80%; padding: 10px; margin: 10px; }
        .login-box button { background: green; color: white; padding: 10px; border: none; cursor: pointer; }
        .login-box button:hover { background: gray; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Officer Login</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="officername">Officer Name</label>
            <input type="text" name="officername" required>
            <label for="officerpassword">Password</label>
            <input type="password" name="officerpassword" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
