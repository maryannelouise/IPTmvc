<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .navbar {
            background-color: #f8f9fa !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #6C63FF !important;
        }

        .nav-link {
            font-weight: 500;
            color: #555 !important;
        }

        .nav-link:hover {
            color: #6C63FF !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light px-3">
        <a class="navbar-brand" href="/careset">CareSet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item"><a class="nav-link" href="/careset/homepage">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/careset/view/about/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/careset/doctors">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="/careset/schedule">Schedule</a></li>
            </ul>

            <div class="search-bar">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            </div>
        </div>
    </nav>
</body>
</html>
