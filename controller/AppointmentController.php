<?php
namespace App\Controller;

require_once __DIR__ . '/../model/AppointmentModel.php';
require_once __DIR__ . '/../database/db.php'; // Ensure database connection
require_once __DIR__ . '/../helpers/Validator.php';

class AppointmentController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Model\AppointmentModel();
    }

    public function showScheduleForm()
    {
        // Simply include the view file
        include __DIR__ . '/../view/Schedule/schedule.php';
    }

    public function create()
    {
        // Process file uploads
        $medicalRecords = [];
        if (!empty($_FILES['medical_records'])) {
            foreach ($_FILES['medical_records']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['medical_records']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileContent = file_get_contents($tmpName);
                    $medicalRecords[] = [
                        'filename' => $_FILES['medical_records']['name'][$key],
                        'description' => $_POST['file_description'][$key] ?? '',
                        'content' => base64_encode($fileContent)
                    ];
                }
            }
        }

        // Process diseases (array to string)
        $diseases = implode(', ', $_POST['disease'] ?? []);

        // Data for appointment
        $data = [
            'doctor_id' => $_POST['doctor_id'] ?? null,
            'firstname' => $_POST['firstname'] ?? '',
            'lastname' => $_POST['lastname'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'birthdate' => $_POST['birthdate'] ?? '',
            'appointment_date' => $_POST['appointment_date'] ?? '',
            'medical_records' => $medicalRecords,
            'diseases' => $diseases
        ];

        // Setup validation rules
        $validator = new \App\Helpers\Validator();
        $validator->setRules([
            'doctor_id' => ['required' => true],
            'firstname' => ['required' => true, 'minLength' => 2],
            'lastname' => ['required' => true, 'minLength' => 2],
            'appointment_date' => ['required' => true]
        ]);

        // Set data to validate
        $validator->attributes = $data;

        // Validate data
        if (!$validator->validate()) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Validation failed',
                'details' => $validator->getErrors()
            ]);
            return;
        }

        // Create appointment
        try {
            $success = $this->model->createAppointment($data);
            if ($success) {
                http_response_code(201);
                echo json_encode(['message' => 'Appointment created successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create appointment']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function getByDoctor($doctorId)
    {
        try {
            $appointments = $this->model->getAppointmentsByDoctor($doctorId);
            http_response_code(200);
            echo json_encode($appointments);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function get($appointmentId)
    {
        try {
            $appointment = $this->model->getAppointmentById($appointmentId);
            if ($appointment) {
                http_response_code(200);
                echo json_encode($appointment);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Appointment not found']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function update($appointmentId)
    {
        parse_str(file_get_contents('php://input'), $_PUT);

        $data = [
            'firstname' => $_PUT['firstname'] ?? '',
            'lastname' => $_PUT['lastname'] ?? '',
            'gender' => $_PUT['gender'] ?? '',
            'birthdate' => $_PUT['birthdate'] ?? '',
            'appointment_date' => $_PUT['appointment_date'] ?? '',
            'medical_records' => $_PUT['medical_records'] ?? [],
            'diseases' => $_PUT['diseases'] ?? ''
        ];

        try {
            $success = $this->model->updateAppointment($appointmentId, $data);
            if ($success) {
                http_response_code(200);
                echo json_encode(['message' => 'Appointment updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update appointment']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function cancel($appointmentId)
    {
        try {
            $success = $this->model->cancelAppointment($appointmentId);
            if ($success) {
                http_response_code(200);
                echo json_encode(['message' => 'Appointment cancelled successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to cancel appointment']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // ✅ NEW: get available times for a specific doctor
    public function getDoctorAvailableTimes($doctorId)
    {
        try {
            $availableTimes = $this->model->getDoctorTimes($doctorId);
            http_response_code(200);
            echo json_encode($availableTimes);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function handleApiRequest($appointmentId = null)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST':
                return $this->create();
            case 'GET':
                if (isset($_GET['available_times_for'])) {
                    return $this->getDoctorAvailableTimes($_GET['available_times_for']);
                }
                if ($appointmentId) {
                    return $this->get($appointmentId);
                }
                return $this->getByDoctor($_GET['doctor_id'] ?? 0);
            case 'PUT':
                return $this->update($appointmentId);
            case 'DELETE':
                return $this->cancel($appointmentId);
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
