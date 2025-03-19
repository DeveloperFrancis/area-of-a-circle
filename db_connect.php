<?php
$host = "localhost"; // Change if using an external server
$user = "root"; // Your MySQL username
$pass = ""; // Your MySQL password (default is empty)
$dbname = "prisoner_regestration_system"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error and die (or send a custom message for user)
    error_log("Connection failed: " . $conn->connect_error);  // Log the error to the server's log file
    die("Sorry, we're having some trouble connecting to the database. Please try again later.");  // Friendly message
} else {
    // Connection is successful, you can uncomment this line to check the connection
    // echo "Connected successfully";
}
?>
