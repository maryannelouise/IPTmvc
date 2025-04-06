<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSet</title>
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

        .stethoscope-wrapper {
            background-color: white;
            border-radius: 50%;
            width: 280px;
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stethoscope-img {
            max-width: 70%;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }


        .btn-primary {
            background-color: #6C63FF;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #847EFF;
        }

        .btn-secondary {
            background-color: #E0DEFF;
            border: none;
            color: #333;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: #d0ceff;
        }

        .feature-box {
            background-color: #ffffffcc;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .section-heading {
            margin-top: 80px;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
            color: #444;
        }

        .doctor-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .doctor-card:hover {
            transform: scale(1.05);
        }

        .doctor-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <!-- Main Content -->
    <main class="main-wrapper">
        <!-- Hero Section -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-section">
                    <h1 class="display-4 fw-bold mb-3">Your Health, Our Priority</h1>
                    <p class="lead mb-4"> Book Your Care, Anytime, Anywhere</p>
                    <a href="/careset/schedule" class="btn btn-primary btn-lg me-2">Book Now</a>
                    <a href="/careset/view/about/about.php" class="btn btn-secondary btn-lg">Learn More</a>
                </div>
                <div class="col-md-6 text-center">
                    <div class="stethoscope-wrapper mx-auto">
                        <img src="./assets/images/stethoscope.png" class="stethoscope-img" alt="Stethoscope">
                    </div>
                </div>
            </div>


            <!-- Features -->
            <div class="container" id="services">
                <h2 class="section-heading">How CareSet Helps You</h2>
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <h4>📅 Book Your Care</h4>
                            <p>Schedule appointments with ease, anytime and from anywhere.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <h4>🩺 Get Professional Help</h4>
                            <p>Connect with licensed doctors and medical professionals quickly.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <h4>💖 Stay Healthy</h4>
                            <p>Track your health and maintain wellness with personalized care tips.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specialties -->
            <div class="container">
                <h2 class="section-heading">Find a Medical Specialty</h2>
                <div class="row text-center">
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Cardiology</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Dermatology</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">General Physician</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Orthopedics</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Gynecologist</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Pediatricians</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Neurology</div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-box">Psychiatry</div>
                    </div>
                </div>
            </div>

            <!-- Top Doctors -->
            <div class="container mb-5">
                <h2 class="section-heading">Top Doctors</h2>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            <img src="./assets/images/doctor/john_doe.png" class="doctor-img">
                            <h5>Dr. John Doe</h5>
                            <p>Cardiologist</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            <img src="./assets/images/doctor/jane_smith.png" class="doctor-img">
                            <h5>Dr. Jane Smith</h5>
                            <p>Dermatologist</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="doctor-card">
                            <img src="./assets/images/doctor/alice_brown.png" class="doctor-img">
                            <h5>Dr. Alice Brown</h5>
                            <p>Neurologist</p>
                        </div>
                    </div>


                </div>
            </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>