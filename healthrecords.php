<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prisoner_regestration_system";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch prisoner details including health information
$sql = "SELECT prisoner_number, prisoner_name, id_number, age, judge_name, admission_date, term_limit, photo_path, health_condition, blood_group, visit_date FROM prisoners_details";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisoner Records - Prison Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .photo img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Prisoner Records</h1>

        <table>
            <tr>
                <th>Prisoner Number</th>
                <th>Name</th>
                <th>ID Number</th>
                <th>Age</th>
                <th>Judge Name</th>
                <th>Admission Date</th>
                <th>Term Limit</th>
                <th>Health Condition</th>
                <th>Blood Group</th>
                <th>Last Visit</th>
                <th>Photo</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['prisoner_number']}</td>
                        <td>{$row['prisoner_name']}</td>
                        <td>{$row['id_number']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['judge_name']}</td>
                        <td>{$row['admission_date']}</td>
                        <td>{$row['term_limit']} years</td>
                        <td>{$row['health_condition']}</td>
                        <td>{$row['blood_group']}</td>
                        <td>{$row['visit_date']}</td>
                        <td class='photo'>
                            <img src='{$row['photo_path']}' alt='No Image'>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No prisoner records found.</td></tr>";
            }
            ?>

        </table>
    </div>

</body>
</html>

<?php
$conn->close();
?>
