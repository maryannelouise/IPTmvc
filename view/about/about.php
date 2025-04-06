<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - CareSet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: linear-gradient(#A294F9, #CDC1FF, #E5D9F2, #F5EFFF);
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Raleway', sans-serif;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
        }

        .container {
            margin-top: 50px;
        }

        .about-img-wrapper {
            background-color: white;
            border-radius: 15px;
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .about-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .about-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-heading {
            margin-top: 50px;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
            color: #444;
        }

        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }

        .team-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <main class="main-wrapper">
        <div class="container">
            <div class="about-img-wrapper">
                <img src="/careset/assets/images/background-doc.png" class="about-img" alt="Medical Team">
            </div>
           
            <div class="about-card">
                <h1 class="display-4 fw-bold mb-4">About CareSet</h1>
                <p class="lead">Connecting patients with quality healthcare providers since 2025.</p>
                
                <div class="row mt-5">
                    <div class="col-md-6">
                        <h3 class="mb-3">Our Mission</h3>
                        <p>To make healthcare accessible and convenient for everyone by providing a seamless platform for booking medical appointments with trusted professionals.</p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-3">Our Vision</h3>
                        <p>To revolutionize healthcare access by creating a network of top medical professionals available at your fingertips, reducing wait times and improving patient outcomes.</p>
                    </div>
                </div>
            </div>

            <h2 class="section-heading">Meet Our Team</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="/careset/assets/images/team/ceo.png" class="team-img" alt="CEO">
                        <h4>Dr. Sarah Johnson</h4>
                        <p>Founder & CEO</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="/careset/assets/images/team/cto.png" class="team-img" alt="CTO">
                        <h4>Michael Chen</h4>
                        <p>Chief Technology Officer</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="/careset/assets/images/team/cmo.png" class="team-img" alt="CMO">
                        <h4>Dr. Robert Williams</h4>
                        <p>Chief Medical Officer</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
