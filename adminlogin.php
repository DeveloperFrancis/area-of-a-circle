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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $password_hash, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && hash("sha256", $password) === $password_hash) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        switch ($role) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'warden':
                header("Location: warden_dashboard.php");
                break;
            case 'officer':
                header("Location: officer_dashboard.php");
                break;
        }
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
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #222; color: white; }
        form { background: #333; padding: 20px; border-radius: 10px; width: 300px; margin: auto; margin-top: 100px; box-shadow: 0 0 10px rgba(255, 0, 0, 0.5); }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background-color: red; color: white; padding: 10px; border: none; width: 100%; cursor: pointer; }
        button:hover { background-color: darkred; }
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="adminhomepage.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
