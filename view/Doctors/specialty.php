<?php
require_once __DIR__ . '/../../model/DoctorModel.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo "Missing specialty ID.";
    exit;
}

$specialtyId = intval($_GET['id']);

$doctorModel = new DoctorModel();
$doctors = $doctorModel->getDoctorsBySpecialty($specialtyId);

// Output doctor cards HTML
foreach ($doctors as $doctor) {
    $imagePath = '/careset/assets/images/doctor/' . basename($doctor['image']); // Make sure to include '/careset' in the URL
    echo '
    <div class="doctor-card">
        <img src="' . htmlspecialchars($imagePath) . '" class="doctor-img" alt="' . htmlspecialchars($doctor['name']) . '">
        <h4>' . htmlspecialchars($doctor['name']) . '</h4>
        <p>' . htmlspecialchars($doctor['description']) . '</p>
        <a href="/careset/schedule?doctor_id=' . $doctor['id'] . '" class="btn btn-primary">Schedule Appointment</a>
    </div>';
}
?>
