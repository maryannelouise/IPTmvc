<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if required session variables exist and are not empty
if (empty($_SESSION['doctor_name']) || empty($_SESSION['appointment_date'])) {
    header("Location: /doctors?error=missing_appointment_details");
    exit();
}

// Get the session data with fallback values
$doctor_name = $_SESSION['doctor_name'] ?? '';
$appointment_date = $_SESSION['appointment_date'] ?? '';
$available_time = $_SESSION['available_time'] ?? $_SESSION['available_time'] ?? '';

// Clear the session data after displaying it
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Raleway', sans-serif;
        }

        .success-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }

        .confirmation-details {
            background: #f1f8ff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .btn-primary {
            background-color: #5B5EA6;
            border-color: #5B5EA6;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container">
        <div class="success-card">
            <h1 class="mb-4">Appointment Confirmed!</h1>
            <div class="confirmation-details">
                <p class="h5"><strong>Doctor:</strong> <?= htmlspecialchars($doctor_name) ?></p>
                <p class="h5"><strong>Date:</strong> <?= date('F j, Y', strtotime($appointment_date)) ?></p>
                <p class="h5"><strong>Time:</strong> 
                <?php 
                // Format time from database format (09:00:00) to 12-hour format (9:00 AM)
                $time_obj = DateTime::createFromFormat('H:i:s', $available_time);
                $formatted_time = $time_obj ? $time_obj->format('g:i A') : $available_time;
                echo htmlspecialchars($formatted_time);
                ?></p>
            </div>
            <p class="mb-4">A confirmation has been sent to your email with all the details.</p>
            <a href="/careset/doctors" class="btn btn-primary px-4">Back to Doctors</a>
        </div>
    </div>
</body>

</html>