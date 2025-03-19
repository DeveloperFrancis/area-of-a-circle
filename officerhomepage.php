<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Homepage - Prison System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            background: #fff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .logout-btn {
            display: block;
            background: green;
            color: white;
            text-align: center;
            padding: 10px;
            margin: 20px auto;
            width: 70px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <div class="header">Officer Dashboard - Prison System</div>

    <div class="container">
        <h2>Welcome, Officer</h2>

        <div class="card">
            <h3>Inmate Management</h3>
            <p>View and update inmate records, including personal details, status, and assigned cells.</p>
            <a href="#" class="btn" onclick="redirectToPdetails()">Prisoners Details</a>
        </div>

        <div class="card">
            <h3>Visitation Schedule</h3>
            <p>Review and approve visitor requests for inmates.</p>
            <a href="#" class="btn" onclick="redirectToVisitors()">View Visits</a>
        </div>

        <div class="card">
            <h3>Messages & Notifications</h3>
            <p>Check important messages from the admin or other officers.</p>
            <a href="messages.php" class="btn">Check Messages</a>
        </div>
        <div class="card">
            <h3>Cell Allocation</h3>
            <p>Allocate and manage cells to new and existing prisoners.</p>
            <a href="cell_allocations.php" class="btn">Cells allocation</a>
        </div>
        <div>
            <a href="#" class="logout-btn" onclick="redirectToHomepage()">Logout</a>
        </div>

       
    </div>
    <script>
        function redirectToPdetails() {
            window.location.href = "update_prisoners_details.php";
        }
    function redirectToVisitors() {
            window.location.href = "visitationmanagement.php"; 
        }
    function redirectToMessages() {
            window.location.href = "messages.php";
        }
    function redirectToStaffdetails() {
            window.location.href = "staffdetails.php";
        }
    function redirectToSettings() {
            window.location.href = "settings.php";
        }
    function redirectToHomepage() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>