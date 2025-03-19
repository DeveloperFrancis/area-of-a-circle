<?php
// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "prisoner_regestration_system"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle cell allocation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['allocate'])) {
    $prisoner_id = $_POST['prisoner_id'];
    $cell_number = $_POST['cell_number'];
    $block = $_POST['block'];
    $allocation_date = $_POST['allocation_date'];

    // Check if prisoner exists
    $check_prisoner = $conn->query("SELECT * FROM prisoners_details WHERE prisoner_id = '$prisoner_id'");
    if ($check_prisoner->num_rows > 0) {
        // Insert allocation if prisoner exists
        $sql = "INSERT INTO cell_allocations (prisoner_id, cell_number, block, allocation_date)
                VALUES ('$prisoner_id', '$cell_number', '$block', '$allocation_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Cell allocated successfully!'); window.location.href='cell_allocations.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error: Prisoner ID does not exist!');</script>";
    }
}

// Handle delete allocation
if (isset($_POST['delete'])) {
    $allocation_id = $_POST['allocation_id'];
    $delete_sql = "DELETE FROM cell_allocations WHERE allocation_id='$allocation_id'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Cell allocation deleted successfully!'); window.location.href='cell_allocations.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
}

// Fetch all allocations
$allocations = $conn->query("SELECT * FROM cell_allocations");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cell Allocation System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        .delete {
            background: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Cell Allocation Form</h2>
        <form id="cellForm" action="cell_allocations.php" method="POST">
            <label for="prisoner_id">Prisoner ID:</label>
            <input type="number" id="prisoner_id" name="prisoner_id" required>

            <label for="cell_number">Cell Number:</label>
            <input type="text" id="cell_number" name="cell_number" required>

            <label for="block">Block:</label>
            <select id="block" name="block" required>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>

            <label for="allocation_date">Allocation Date:</label>
            <input type="date" id="allocation_date" name="allocation_date" required>

            <button type="submit" name="allocate">Allocate Cell</button>
        </form>

        <h2>Allocated Cells</h2>
        <table>
            <thead>
                <tr>
                    <th>Prisoner ID</th>
                    <th>Cell Number</th>
                    <th>Block</th>
                    <th>Allocation Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $allocations->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['prisoner_id'] ?></td>
                        <td><?= $row['cell_number'] ?></td>
                        <td><?= $row['block'] ?></td>
                        <td><?= $row['allocation_date'] ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                               <input type="hidden" name="allocation_id" value="<?= $row['allocation_id'] ?>">
                                <button type="submit" name="delete" class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("cellForm").addEventListener("submit", function(event) {
            let prisonerId = document.getElementById("prisoner_id").value;
            let cellNumber = document.getElementById("cell_number").value;

            if (prisonerId === "" || cellNumber === "") {
                alert("All fields must be filled out.");
                event.preventDefault();
            }
        });
    </script>

</body>
</html>
<?php $conn->close(); ?>
