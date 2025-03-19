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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $prisoner_number = mysqli_real_escape_string($conn, $_POST['prisoner_number']);
    $prisoner_name = mysqli_real_escape_string($conn, $_POST['prisoner_name']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $judge_name = mysqli_real_escape_string($conn, $_POST['judge_name']);
    $admission_date = mysqli_real_escape_string($conn, $_POST['admission_date']);
    $term_limit = mysqli_real_escape_string($conn, $_POST['term_limit']);

    // Health details
    $health_condition = mysqli_real_escape_string($conn, $_POST['health_condition']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $allergies = isset($_POST['allergies']) ? mysqli_real_escape_string($conn, $_POST['allergies']) : "";
    $medications = isset($_POST['medications']) ? mysqli_real_escape_string($conn, $_POST['medications']) : "";
    $visit_date = mysqli_real_escape_string($conn, $_POST['visit_date']);
    $emergency_contact = isset($_POST['emergency_contact']) ? mysqli_real_escape_string($conn, $_POST['emergency_contact']) : "";

    // Handle file upload
    $photo_path = "";
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $photo_path = $target_dir . basename($_FILES["photo"]["name"]);
        
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path)) {
            die("Error uploading photo.");
        }
    } else {
        die("No photo uploaded.");
    }

    // Insert prisoner details including health records
    $sql_prisoner = "INSERT INTO prisoners_details (prisoner_number, prisoner_name, id_number, age, judge_name, admission_date, term_limit, photo_path, health_condition, blood_group, visit_date) 
                     VALUES ('$prisoner_number', '$prisoner_name', '$id_number', '$age', '$judge_name', '$admission_date', '$term_limit', '$photo_path', '$health_condition', '$blood_group', '$visit_date')";

    if ($conn->query($sql_prisoner) === TRUE) {
        echo "<script>alert('Prisoner detail added successfully!'); window.location.href='update_prisoners_details.php';</script>";
    } else {
        die("Error inserting prisoner details: " . $conn->error);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prisoner - Prison Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            background: #333;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Add New Prisoner</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="prisoner_name">Prisoner Name:</label>
                <input type="text" id="prisoner_name" name="prisoner_name" required>
            </div>

            <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="prisoner_number">Prisoner Number:</label>
                <input type="text" id="prisoner_number" name="prisoner_number" required>
            </div>

            <div class="form-group">
                <label for="judge_name">Judge Name:</label>
                <input type="text" id="judge_name" name="judge_name" required>
            </div>

            <div class="form-group">
                <label for="admission_date">Admission Date:</label>
                <input type="date" id="admission_date" name="admission_date" required>
            </div>

            <div class="form-group">
                <label for="term_limit">Term Limit (Years):</label>
                <input type="number" id="term_limit" name="term_limit" required>
            </div>

            <div class="form-group">
                <label for="photo">Upload Photo:</label>
                <input type="file" id="photo" name="photo" required>
            </div>

            <h2>Health Details</h2>

            <div class="form-group">
                <label for="health_condition">Health Condition:</label>
                <textarea id="health_condition" name="health_condition" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="">Select</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>

            <div class="form-group">
                <label for="visit_date">Last Visit Date:</label>
                <input type="date" id="visit_date" name="visit_date" required>
            </div>

            <button type="submit" class="submit-btn">Submit Prisoner</button>
        </form>
    </div>

</body>
</html>



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
                <th>Actions</th>
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
                <td>
                    <a href="edit_prisoner.php?id=<?= $row['prisoner_number']; ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_prisoner.php?id=<?= $row['prisoner_number']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <div>
        <a href="officerhomepage.php" class="logout-btn">Home</a>
    </div>

</body>
</html>
