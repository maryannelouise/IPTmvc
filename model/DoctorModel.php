<?php
require_once __DIR__ . '/../database/db.php';

class DoctorModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getSpecialties() {
        $result = $this->conn->query("SELECT * FROM doctor_specialties");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDoctorsBySpecialty($specialtyId) {
        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE specialty_id = ?");
        $stmt->bind_param("i", $specialtyId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch available times for a doctor from doctor_availability
    public function getDoctorAvailability($doctorId) {
        $stmt = $this->conn->prepare(
            "SELECT available_time FROM doctor_availability 
             WHERE doctor_id = ? 
             ORDER BY available_time"
        );
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return array_column($result->fetch_all(MYSQLI_ASSOC), 'available_time');
    }

    public function bookAppointment($data) {
        // Set default empty values for optional fields
        $data['medical_records'] = $data['medical_records'] ?? [];
        $data['diseases'] = $data['diseases'] ?? [];
        
        // Validate required fields
        $requiredFields = ['doctor_id', 'firstname', 'lastname', 'gender', 'birthdate', 'appointment_date'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Required field missing: $field");
            }
        }

        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO appointments 
                (doctor_id, firstname, lastname, gender, birthdate, appointment_date, medical_records, diseases) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            
            $medicalRecordsJson = json_encode($data['medical_records']);
            // Convert diseases array to comma-separated string if it's an array
            $diseasesStr = is_array($data['diseases']) ? 
                implode(', ', $data['diseases']) : 
                $data['diseases'];
            
            $stmt->bind_param(
                "isssssss", 
                $data['doctor_id'],
                $data['firstname'],
                $data['lastname'],
                $data['gender'],
                $data['birthdate'],
                $data['appointment_date'],
                $medicalRecordsJson,
                $diseasesStr
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Appointment booking failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function getDoctorById($doctorId) {
        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getDoctorName($doctorId) {
        $stmt = $this->conn->prepare("SELECT name FROM doctors WHERE id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['name'] ?? '';
    }

    public function getAvailableDoctors() {
        $result = $this->conn->query("SELECT id, name, specialty_id FROM doctors");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllDoctors() {
        $result = $this->conn->query("SELECT id, name, specialty_id FROM doctors");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestAppointment() {
        $query = "SELECT a.*, d.name as doctor_name, da.available_time
                  FROM appointments a
                  JOIN doctors d ON a.doctor_id = d.id
                  JOIN doctor_availability da ON a.doctor_id = da.doctor_id
                  ORDER BY a.created_at DESC 
                  LIMIT 1";
                  
        $result = $this->conn->query($query);
        $appointment = $result->fetch_assoc();
        
        if ($appointment) {
            // Format the date and time for display if they exist
            if (isset($appointment['appointment_date'])) {
                $appointment['appointment_date'] = date('Y-m-d', strtotime($appointment['appointment_date']));
            }
            if (isset($appointment['available_time'])) {
                $appointment['available_time'] = date('H:i:s', strtotime($appointment['available_time']));
            }
        }
        
        return $appointment;
    }
}
?>
