<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #A294F9, #CDC1FF, #E5D9F2, #F5EFFF);
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .hero-section {
            text-align: left;
            padding: 50px;
            border-radius: 10px;
        }

        .stethoscope-img {
            max-width: 300px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-brand {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
        }

        .search-bar {
            margin-left: auto;
        }

        .btn-primary {
            background-color: #757BC8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #CDC1FF;
            color: black;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <div class="d-flex">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Schedule</a></li>
                </ul>
            </div>
        </div>

        <a class="navbar-brand" href="#">CareSet</a>

        <div class="search-bar">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
        </div>
    </nav>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 hero-section">
                <h1 class="display-4">CareSet</h1>
                <button class="btn btn-primary">
                    <h3>Book Your Care, Anytime, Anywhere</h3>
                </button>
                <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ex gravida vitae vel
                    orci.</p>
                <button class="btn btn-secondary">Book Now</button>
            </div>
            <div class="col-md-6 text-center">
                <img src="../assets/images/stethoscope.png" class="stethoscope-img">
            </div>
        </div>
    </div>
</body>

</html>
