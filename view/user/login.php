<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/careset/database/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/careset/controller/UserController.php';

$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userController->login(); 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - CareSet</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #A294F9, #CDC1FF, #E5D9F2, #F5EFFF);
        }

        .form-container {
            display: flex;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 800px;
        }

        .careset {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 64px;
            font-weight: bold;
            color: #4A4A4A;
            width: 50%;
            font-family: Georgia, serif;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .form-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            color: #4A4A4A;
            margin-bottom: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        input {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 40%;
            align-items: center;
            margin-top: 10px;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="careset">CareSet</div>
        <div class="form-content">
            <h2>Log In</h2>

            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Log In</button>
            </form>

            <div class="footer">
                <p>Don't have an account? <a href="/careset/register">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>

</html>