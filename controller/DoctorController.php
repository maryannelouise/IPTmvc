<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../model/DoctorModel.php';

class DoctorController {
    private $doctorModel;

    public function __construct() {
        $this->doctorModel = new DoctorModel();
    }

    public function index() {
        $this->showDoctorsPage();
    }

    public function bookAppointment() {
        try {
            // Validate CSRF token if you're using one
            // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            //     throw new Exception("Invalid CSRF token");
            // }

            // Validate required fields
            $requiredFields = ['doctor_id', 'firstname', 'lastname', 'gender', 'birthdate', 'appointment_date'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Missing required field: " . $field);
                }
            }

            // Process file uploads
            $medicalRecords = [];
            if (!empty($_FILES['medical_records'])) {
                $medicalRecords = $this->processFileUploads($_FILES['medical_records'], $_POST['file_description'] ?? []);
            }

            // Prepare data for model
            $appointmentData = [
                'doctor_id' => (int)$_POST['doctor_id'],
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'gender' => $_POST['gender'],
                'birthdate' => $_POST['birthdate'],
                'appointment_date' => $_POST['appointment_date'],
                'medical_records' => $medicalRecords,
                'diseases' => $_POST['disease'] ?? []
            ];

            // Validate date formats
            if (!strtotime($appointmentData['birthdate']) || !strtotime($appointmentData['appointment_date'])) {
                throw new Exception("Invalid date format");
            }

            // Call model to save appointment
            $result = $this->doctorModel->bookAppointment($appointmentData);

            if ($result) {
                // Success - redirect to confirmation page
                header("Location: /careset/doctors/success");
                exit();
            } else {
                throw new Exception("Failed to book appointment");
            }

        } catch (Exception $e) {
            // Log the error
            error_log("Appointment booking error: " . $e->getMessage());
            
            // Return JSON error for AJAX requests
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    private function processFileUploads($files, $descriptions) {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../uploads/medical_records/';
        
        // Create upload directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Process each file
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                continue; // Skip failed uploads
            }

            // Validate file type and size
            $maxSize = 5 * 1024 * 1024; // 5MB
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
            
            if ($files['size'][$i] > $maxSize) {
                throw new Exception("File too large: " . $files['name'][$i]);
            }
            
            if (!in_array($files['type'][$i], $allowedTypes)) {
                throw new Exception("Invalid file type: " . $files['name'][$i]);
            }

            // Generate unique filename
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $destination = $uploadDir . $filename;

            // Move uploaded file
            if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                $uploadedFiles[] = [
                    'path' => '/uploads/medical_records/' . $filename,
                    'description' => $descriptions[$i] ?? 'Medical record'
                ];
            }
        }

        return $uploadedFiles;
    }

    public function getSpecialties() {
        $specialties = $this->doctorModel->getSpecialties();
        echo json_encode($specialties);
    }

    public function getDoctorsBySpecialty($specialtyId) {
        $doctors = $this->doctorModel->getDoctorsBySpecialty($specialtyId);
        echo json_encode($doctors);
    }

    public function getDoctorAvailability($doctorId) {
        $availability = $this->doctorModel->getDoctorAvailability($doctorId);
        echo json_encode($availability);
    }

    public function showDoctorsPage() {
        $specialties = $this->doctorModel->getSpecialties();
        include __DIR__ . '/../view/Doctors/doctor.php';
    }

    public function showSuccess() {
        // Ensure session is started only once
        if (!isset($_SESSION)) {
            session_start();
        }

        // Get the latest appointment details from model
        $appointment = $this->doctorModel->getLatestAppointment();
        
        if ($appointment) {
            // Set session variables for the view
            $_SESSION['doctor_name'] = $appointment['doctor_name'] ?? '';
            $_SESSION['appointment_date'] = $appointment['appointment_date'] ?? '';
            $_SESSION['available_time'] = $appointment['available_time'] ?? '';
        } else {
            // Handle case where no appointment is found
            $_SESSION['error_message'] = "No appointment details found";
            header("Location: /doctors");
            exit();
        }

        // Include the success view
        include __DIR__ . '/../view/Doctors/success.php';
    }
}
