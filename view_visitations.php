<?php
// Database Connection
$host = "localhost";  // Change if using a remote server
$user = "root";       // Your database username
$pass = "";           // Your database password
$dbname = "prisoner_regestration_system"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission (Insert Data into Visits Table)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["visitor_name"])) {
    $visitor_name = $_POST["visitor_name"];
    $inmate_name = $_POST["inmate_name"];
    $visit_date = $_POST["visit_date"];
    $visit_time = $_POST["visit_time"];

    $stmt = $conn->prepare("INSERT INTO visits (visitor_name, inmate_name, visit_date, visit_time, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssss", $visitor_name, $inmate_name, $visit_date, $visit_time);

    echo $stmt->execute() ? "success" : "error: " . $conn->error;
    $stmt->close();
    exit();
}

// Handle Visit Approval or Rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateStatus"])) {
    $id = $_POST["id"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE visits SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    echo $stmt->execute() ? "success" : "error: " . $conn->error;
    $stmt->close();
    exit();
}

// Retrieve Visit Data
$result = $conn->query("SELECT * FROM visits");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitation Management - Prison System</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .header { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 24px; }
        .container { width: 80%; margin: 20px auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #28a745; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background-color: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; text-align: left; }
        th, td { padding: 10px; }
        th { background-color: #333; color: white; }
        .approve, .reject { padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px; }
        .approve { background: green; color: white; }
        .reject { background: red; color: white; }
    </style>
</head>
<body>

    <div class="header">Visitation Management - Prison System</div>

    <div class="container">
       

        <h2>Upcoming Visits</h2>
        <table>
            <thead>
                <tr>
                    <th>Visitor Name</th>
                    <th>Prisoner Id</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody id="visitList">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["visitor_name"]) ?></td>
                    <td><?= htmlspecialchars($row["prisoner_id"]) ?></td>
                    <td><?= htmlspecialchars($row["visit_date"]) ?></td>
                    <td><?= htmlspecialchars($row["visit_time"]) ?></td>
                    <td id="status-<?= $row['id'] ?>"><?= htmlspecialchars($row["status"]) ?></td>
                    
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("visitForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData();
            formData.append("visitor_name", document.getElementById("visitor_name").value);
            formData.append("prisoner_id", document.getElementById("prisoner_id").value);
            formData.append("visit_date", document.getElementById("visit_date").value);
            formData.append("visit_time", document.getElementById("visit_time").value);

            fetch("visitationmanagement.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Visit Scheduled Successfully!");
                    location.reload();
                } else {
                    alert("Error scheduling visit: " + data);
                }
            })
            .catch(error => console.error("Error:", error));
        });

        function updateStatus(visitId, status) {
            let formData = new FormData();
            formData.append("updateStatus", true);
            formData.append("id", visitId);
            formData.append("status", status);

            fetch("visitationmanagement.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    document.getElementById("status-" + visitId).innerText = status;
                    alert("Status Updated Successfully!");
                } else {
                    alert("Error updating status: " + data);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
