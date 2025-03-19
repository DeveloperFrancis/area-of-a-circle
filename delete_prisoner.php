<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM prisoners_details WHERE prisoner_number = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    echo "Prisoner deleted successfully!";
    header("Location: update_prisoners_details.php");
    exit;
} else {
    echo "Invalid request!";
}
?>
