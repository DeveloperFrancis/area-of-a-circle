<?php
require 'db_connect.php'; // Ensure this file correctly connects to MySQL

// Fetch prisoner details from the database
$query = "SELECT * FROM prisoners_details";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisoner Details - Prison Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: white;
        }
        .container {
            width: 95%;
            margin: 20px auto;
            background: #222;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        h1, h2 {
            text-align: center;
            color: red;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: black;
            color: white;
        }
        table, th, td {
            border: 1px solid red;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: red;
            color: white;
        }
        .prisoner-photo {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .edit-btn {
            background: green;
        }
        .edit-btn:hover {
            background: darkgreen;
        }
        .delete-btn {
            background: red;
        }
        .delete-btn:hover {
            background: darkred;
        }
        .logout-btn {
            display: block;
            background: red;
            color: white;
            text-align: center;
            padding: 10px;
            margin: 20px auto;
            width: 15%;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Prisoner Details</h1>

        <h2>Prisoner Records</h2>
        <table> 
            <tr>
                <th>Photo</th>
                <th>Prisoner Number</th>
                <th>Full Name</th>
                <th>ID Number</th>
                <th>Age</th>
                <th>Judge Name</th>
                <th>Admission Date</th>
                <th>Term Limit</th>
                <th>Health Condition</th>
                <th>Blood Group</th>
                <th>Visit Date</th>
              
            </tr>

            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><img src="<?= htmlspecialchars($row['photo_path']); ?>" alt="Prisoner Photo" class="prisoner-photo"></td>
                <td><?= htmlspecialchars($row['prisoner_number']); ?></td>
                <td><?= htmlspecialchars($row['prisoner_name']); ?></td>
                <td><?= htmlspecialchars($row['id_number']); ?></td>
                <td><?= htmlspecialchars($row['age']); ?></td>
                <td><?= htmlspecialchars($row['judge_name']); ?></td>
                <td><?= htmlspecialchars($row['admission_date']); ?></td>
                <td><?= htmlspecialchars($row['term_limit']); ?> Years</td>
                <td><?= htmlspecialchars($row['health_condition']); ?></td>
                <td><?= htmlspecialchars($row['blood_group']); ?></td>
                <td><?= htmlspecialchars($row['visit_date']); ?></td>
               
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <div>
        <a href="wardenhomepage.php" class="logout-btn">Home</a>
    </div>

</body>
</html>
