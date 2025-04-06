<?php
// Assuming you fetch specialties and doctors in the controller
$doctorModel = new DoctorModel();
$specialties = $doctorModel->getSpecialties();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Doctors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

        h1, h2 {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .specialty-card {
            background-color: #ffffffcc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, background-color 0.3s ease;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .specialty-card:hover {
            transform: translateY(-10px);
            background-color: #A294F9;
            color: #fff;
        }

        .specialty-card h3 {
            margin: 0;
        }

        .specialty-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .doctor-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .doctor-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .doctor-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .doctor-img:hover {
            transform: scale(1.1);
        }

        .btn-primary {
            background-color: #6C63FF;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #847EFF;
        }

        .doctor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .section-heading {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 30px;
        }

    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-center">Find a Doctor</h1>

        <div class="row">
            <!-- Specialties Column -->
            <div class="col-md-4">
                <h2 class="section-heading text-center">Specialties</h2>
                <div class="specialty-list">
                    <?php foreach ($specialties as $specialty): ?>
                        <a href="javascript:void(0);" class="specialty-card" 
                           onclick="loadDoctors(<?= $specialty['id'] ?>)">
                            <h3><?= htmlspecialchars($specialty['name']) ?></h3>
                            
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Doctors Column -->
            <div class="col-md-8">
                <h2 class="section-heading text-center">Doctors</h2>
                <div id="doctor-list" class="doctor-list">
                    <!-- Doctors will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function loadDoctors(specialtyId) {
        fetch(`view/Doctors/specialty.php?id=${specialtyId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                const doctorList = document.getElementById('doctor-list');
                if (!doctorList) throw new Error('Doctor list container not found');
                
                // Directly use the response HTML since we simplified doctor_list.php
                doctorList.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading doctors:', error);
                const doctorList = document.getElementById('doctor-list');
                if (doctorList) {
                    doctorList.innerHTML = `
                        <div class="alert alert-danger">
                            Failed to load doctors. Please try again later.
                        </div>
                    `;
                }
            });
    }
    </script>
</body>

</html>
