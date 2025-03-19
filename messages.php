<?php
require 'db_connect.php'; // Ensure this file contains $conn = new mysqli(...)

// Handle form submission (sending messages)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient = $_POST["recipient"];
    $message = $_POST["messageText"];
    $sender = "Admin"; // You can change this dynamically

    // Insert message into database
    $stmt = $conn->prepare("INSERT INTO messages (sender, recipient, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sender, $recipient, $message);
    $stmt->execute();

    // Insert notification
    $notification = "New message sent to " . $recipient;
    $stmt = $conn->prepare("INSERT INTO notifications (notification) VALUES (?)");
    $stmt->bind_param("s", $notification);
    $stmt->execute();

    echo "Message Sent Successfully!";
    exit;
}

// Fetch messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");

// Fetch notifications
$notifications = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages & Notifications - Prison System</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
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
        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #333;
            color: white;
        }
        .mark-read {
            background: blue;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
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

    <div class="header">Messages & Notifications - Prison System</div>

    <div class="container">
        <h2>Send Message</h2>
        <form id="messageForm">
            <div class="form-group">
                <label for="recipient">Recipient:</label>
                <select id="recipient" required>
                    <option value="warden">Warden</option>
                    <option value="officer">Prison Officer</option>
                    <option value="staff">Other Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="messageText">Message:</label>
                <textarea id="messageText" rows="4" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>

        <h2>Received Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>From</th>
                    <th>Message</th>
                    
                </tr>
            </thead>
            <tbody id="messageList">
                <?php while ($row = $messages->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['sender']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                      
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Notifications</h2>
        <table>
            <thead>
                <tr>
                    <th>Notification</th>
                    
                </tr>
            </thead>
            <tbody id="notificationList">
                <?php while ($row = $notifications->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['notification']); ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("messageForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData();
            formData.append("recipient", document.getElementById("recipient").value);
            formData.append("messageText", document.getElementById("messageText").value);

            fetch("messages.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Refresh to show new messages
            });
        });

        function markAsRead(id) {
            fetch(`mark_read.php?id=${id}`).then(() => location.reload());
        }

        function deleteMessage(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                fetch(`delete_message.php?id=${id}`).then(() => location.reload());
            }
        }
    </script>

</body>
</html>
