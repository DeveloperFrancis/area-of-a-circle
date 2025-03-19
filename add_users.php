<?php
require 'db_connect.php'; // Ensure this file contains $conn = new mysqli(...);

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        header("Location: add_users.php"); // Redirect after deletion
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Handle new user creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: adminhomepage.php"); // Redirect after adding user
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all users
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
        }
        .container {
            width: 60%;
            margin: auto;
            background: #222;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid red;
        }
        button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkred;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #333;
        }
        th, td {
            padding: 10px;
            border: 1px solid red;
        }
        th {
            background: darkred;
        }
        a {
            color: red;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add New User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="warden">Warden</option>
                <option value="officer">Officer</option>
            </select>

            <button type="submit">Add User</button>
        </form>
    </div>

    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']); ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['user_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
