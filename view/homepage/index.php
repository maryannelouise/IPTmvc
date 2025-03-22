<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSet - Home</title>
    <?php include '../routes/web.php'; ?> <!-- Updated path -->

    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #A294F9, #CDC1FF, #E5D9F2, #F5EFFF);
            margin: 0;
        }

        .hero-section {
            position: relative;
            width: 90%;
            max-width: 1300px;
            height: 80vh;
            background: url('../assets/images/background-doc.png') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 60px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            font-family: Georgia, serif;
            margin: 0;
        }

        p {
            font-size: 22px;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 400px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 18px;
            color: white;
            background-color: #B19CD9; 
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #9F8CD7; 
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <h1>CareSet</h1>
        <p>Where Health Meets Convenience</p>
        <a href="view/UserView.php" class="btn">Get Started</a>
    </div>
</body>
</html>
