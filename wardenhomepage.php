<?php
require 'db_connect.php'; // Ensure this file contains $conn = new mysqli(...)

// Fetch total inmates
$result_prisoners_details = $conn->query("SELECT COUNT(*) AS total FROM prisoners_details");
$total_prisoners_details = ($result_prisoners_details->fetch_assoc())['total'] ?? 0;

// Fetch total users
$result_users = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_users = ($result_users->fetch_assoc())['total'] ?? 0;

// Fetch total visits
$result_visits = $conn->query("SELECT COUNT(*) AS total FROM visits");
$total_visits = ($result_visits->fetch_assoc())['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Dashboard - Prison Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 24px; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background-color: #222; padding-top: 20px; color: white; }
        .sidebar a { display: block; color: white; padding: 15px; text-decoration: none; border-bottom: 1px solid #444; }
        .sidebar a:hover { background-color: #575757; }
        .main-content { margin-left: 260px; padding: 20px; }
        .card { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .logout-btn { display: block; background: red; color: white; text-align: center; padding: 10px; margin: 20px auto; width: 80%; text-decoration: none; border-radius: 5px; }
        .logout-btn:hover { background: darkred; }
    </style>
</head>
<body>

    <div class="header">Prison Management System - Warden Dashboard</div>

    <div class="sidebar">
        <a href="prisonersdetails.php">Prisoners Details</a>
        <a href="healthrecords.php">Health Records</a>
        <a href="view_visitations.php">View visits</a>
        <a href="messages.php">Messages & Notifications</a>
        <a href="logout.php" >Logout</a>
    </div>

    <div class="main-content">
        <h2>Welcome,
        <p>Monitor and manage the prison efficiently.</p>

        <div class="dashboard-grid">
        <div class="card">
                <h3>Total Inmates</h3>
                <p><?php echo $total_prisoners_details; ?></p>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Total Visits</h3>
                <p><?php echo $total_visits; ?></p>
            </div>
        </div>
    </div>

</body>
</html>
