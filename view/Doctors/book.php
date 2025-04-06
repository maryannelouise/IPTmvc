<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../database/db.php');
require_once __DIR__ . '/../../model/AppointmentModel.php';
require_once __DIR__ . '/../../model/DoctorModel.php';

use App\Model\AppointmentModel;

header('Content-Type: text/html; charset=UTF-8');

try {
    // Check if all required fields are present
    $requiredFields = [
        'doctor_id', 'firstname', 'lastname', 'gender', 'birthdate', 
        'appointment_date', 'disease'
    ];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("All fields are required. Missing: $field");
        }
    }

    // Sanitize inputs
    $doctorId = filter_var($_POST['doctor_id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8');
    $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
    $birthdate = htmlspecialchars($_POST['birthdate'], ENT_QUOTES, 'UTF-8');
    $appointmentDate = htmlspecialchars($_POST['appointment_date'], ENT_QUOTES, 'UTF-8');
    // Process diseases as plain string or array of strings
    $diseases = is_array($_POST['disease']) ? 
        array_map('strip_tags', $_POST['disease']) : 
        strip_tags($_POST['disease']);

    // Initialize models
    $appointmentModel = new AppointmentModel();
    $doctorModel = new DoctorModel();

    // Get doctor information
    $doctor = $doctorModel->getDoctorById($doctorId);
    if (!$doctor) {
        throw new Exception("Selected doctor not found");
    }

    // Process medical records if present
    $medicalRecords = [];
    if (!empty($_FILES['medical_records'])) {
        $uploadDir = __DIR__ . '/../../../uploads/medical_records/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        foreach ($_FILES['medical_records']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['medical_records']['error'][$index] !== UPLOAD_ERR_OK) {
                continue; // Skip failed uploads
            }

            // Check file type and size
            if (!in_array($_FILES['medical_records']['type'][$index], $allowedTypes) ||
                $_FILES['medical_records']['size'][$index] > $maxFileSize) {
                continue; // Skip invalid file
            }

            $originalName = basename($_FILES['medical_records']['name'][$index]);
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $newFilename = uniqid('medrec_') . '.' . $fileExtension;
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($tmpName, $destination)) {
                $medicalRecords[] = [
                    'path' => '/uploads/medical_records/' . $newFilename,
                    'description' => $_POST['file_description'][$index] ?? ''
                ];
            }
        }
    }

    // Prepare appointment data
    $appointmentData = [
        'doctor_id' => $doctorId,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'gender' => $gender,
        'birthdate' => $birthdate,
        'appointment_date' => $appointmentDate,
        'medical_records' => $medicalRecords,
        'diseases' => $diseases
    ];

    // Create the appointment
    $result = $appointmentModel->createAppointment($appointmentData);
    
    if (!$result) {
        throw new Exception("Failed to create appointment");
    }

    // Get the doctor's available time
    $availableTime = $doctorModel->getDoctorAvailability($doctorId);
    $firstAvailableTime = !empty($availableTime) ? $availableTime[0] : '';

    // Store confirmation data in session
    $_SESSION['doctor_name'] = $doctor['name'];
    $_SESSION['appointment_date'] = $appointmentDate;
    $_SESSION['available_time'] = $firstAvailableTime;

    // Redirect to success page
    header('Location: /careset/view/Doctors/success.php');
    exit();

} catch (Exception $e) {
    // Display error message
    $_SESSION['error'] = $e->getMessage();
    header('Location: /careset/view/Doctors/book.php');
    exit();
}
?>
