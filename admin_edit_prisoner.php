<?php
require 'db_connect.php';

// Check if prisoner ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing prisoner details
    $stmt = $conn->prepare("SELECT * FROM prisoners_details WHERE prisoner_number = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $prisoner = $result->fetch_assoc();

    if (!$prisoner) {
        echo "Prisoner not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prisoner_number = $_POST['prisoner_number'];
    $name = $_POST['name'];
    $id_number = $_POST['id_number'];
    $age = $_POST['age'];
    $judge_name = $_POST['judge_name'];
    $admission_date = $_POST['admission_date'];
    $term_limit = $_POST['term_limit'];
    $health_condition = $_POST['health_condition'];
    $blood_group = $_POST['blood_group'];
    $visit_date = $_POST['visit_date'];

    // Handle image upload
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "uploads/";
        $photo_path = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path);
    } else {
        $photo_path = $prisoner['photo_path']; // Keep old image if none is uploaded
    }

    // Update query
    $updateStmt = $conn->prepare("UPDATE prisoners_details SET 
        prisoner_number=?, prisoner_name=?, id_number=?, age=?, judge_name=?, 
        admission_date=?, term_limit=?, photo_path=?, health_condition=?, blood_group=?, visit_date=? 
        WHERE prisoner_number=?");

    $updateStmt->bind_param("sssiisssssss", 
        $prisoner_number, $name, $id_number, $age, $judge_name, 
        $admission_date, $term_limit, $photo_path, $health_condition, $blood_group, $visit_date, $id);

    if ($updateStmt->execute()) {
        echo "Prisoner details updated successfully!";
        header("Location: admin_prisoners_management.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Prisoner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
        }
        .form-container {
            width: 50%;
            margin: auto;
            background: #222;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        input, select {
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
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Prisoner Details</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Prisoner Number:</label>
            <input type="text" name="prisoner_number" value="<?= htmlspecialchars($prisoner['prisoner_number']); ?>" required>

            <label>Full Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($prisoner['prisoner_name']); ?>" required>

            <label>ID Number:</label>
            <input type="text" name="id_number" value="<?= htmlspecialchars($prisoner['id_number']); ?>" required>

            <label>Age:</label>
            <input type="number" name="age" value="<?= htmlspecialchars($prisoner['age']); ?>" required>

            <label>Judge Name:</label>
            <input type="text" name="judge_name" value="<?= htmlspecialchars($prisoner['judge_name']); ?>" required>

            <label>Admission Date:</label>
            <input type="date" name="admission_date" value="<?= htmlspecialchars($prisoner['admission_date']); ?>" required>

            <label>Term Limit (Years):</label>
            <input type="number" name="term_limit" value="<?= htmlspecialchars($prisoner['term_limit']); ?>" required>

            <label>Health Condition:</label>
            <input type="text" name="health_condition" value="<?= htmlspecialchars($prisoner['health_condition']); ?>" required>

            <label>Blood Group:</label>
            <input type="text" name="blood_group" value="<?= htmlspecialchars($prisoner['blood_group']); ?>" required>

            <label>Visit Date:</label>
            <input type="date" name="visit_date" value="<?= htmlspecialchars($prisoner['visit_date']); ?>" required>

            <label>Photo (Leave blank to keep current photo):</label>
            <input type="file" name="photo" accept="image/*">

            <button type="submit">Update Prisoner</button>
        </form>
    </div>

</body>
</html>
