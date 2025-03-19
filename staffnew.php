<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details - Kamiti Maximum Prison</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            background: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background: darkgreen;
        }
        .footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
        .footer a {
            color: lightblue;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        Staff Details - Kamiti Maximum Prison
    </div>

    <!-- Staff Form -->
    <div class="container">
        <h2>Enter Staff Details</h2>
        <form action="process_staff.php" method="POST">
            <div class="form-group">
                <label for="name">Staff Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="staff_number">Staff Number:</label>
                <input type="text" id="staff_number" name="staff_number" required>
            </div>

            <div class="form-group">
                <label for="job_group">Job Group:</label>
                <input type="text" id="job_group" name="job_group" required>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

   

    

</body>
</html>