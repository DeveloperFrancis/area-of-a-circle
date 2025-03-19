<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Kamiti Maximum Prison</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            font-size: 28px;
            font-weight: bold;
        }
        .social-media {
            text-align: center;
            padding: 10px;
            background: white;
        }
        .social-media i {
            font-size: 30px;
            margin: 0 15px;
            cursor: pointer;
        }
        .main {
            height: 500px;
            background: url("hpbackground.png") no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: white;
            font-size: 40px;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
        }
        .dropdown {
            position: relative;
            display: inline-block;
            margin-top: 20px;
        }
        .dropbtn {
            background: green;
            color: white;
            font-size: 18px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 160px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            display: block;
            text-decoration: none;
            font-size: 16px;
        }
        .dropdown-content a:hover {
            background: lightgray;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .footer a {
            color: lightblue;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

       <div class="social-media">
        <i class="fa fa-twitter" style="color:lightskyblue"></i>
        <i class="fa fa-instagram" style="color:palevioletred"></i>
        <i class="fa fa-envelope" style="color:black"></i>
        <i class="fa fa-facebook" style="color:blue"></i>
        <i class="fa fa-phone" style="color:black"></i>
    </div>

    <div class="main">
        <p>WELCOME TO KAMITI</p>
        <p>MAXIMUM PRISON</p>

        <div class="dropdown">
            <button class="dropbtn">LOGIN</button>
            <div class="dropdown-content">
                <a href="#" onclick="redirectToLogin()">ADMIN</a>
                <a href="#" onclick="redirectToOfficer()">OFFICER</a>
                <a href="#" onclick="redirectToWarden()">WARDEN</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><a href="#" onclick="redirectToTerms()">Terms & Conditions</a> | &copy; 2025 Kamiti Maximum Prisons. All Rights Reserved.</p>
    </div>

    <script>
        function redirectToLogin() {
            window.location.href = "adminlogin.php";
        }
        function redirectToOfficer() {
            window.location.href = "officerloginpage.php"; 
        }
        function redirectToWarden() {
            window.location.href = "wardenloginpage.php";
        }
        function redirectToTerms() {
            window.location.href = "Terms&conditions.php";
        }
    </script>

</body>
</html>