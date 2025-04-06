<?php
namespace App\Model;
require_once __DIR__ . '/../database/db.php';

class AppointmentModel
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        if (!$this->conn) {
            throw new \RuntimeException('Database connection failed');
        }
    }

    public function createAppointment($data)
    {
        // Validate required fields
        if (empty($data['doctor_id']) || empty($data['firstname']) || empty($data['lastname']) || 
            empty($data['gender']) || empty($data['birthdate']) || empty($data['appointment_date'])) {
            throw new \InvalidArgumentException('Missing required appointment data');
        }

        // Prepare data for storage
        $medicalRecords = $data['medical_records'] ?? [];
        $medicalRecordsJson = json_encode($medicalRecords);
        if ($medicalRecordsJson === false) {
            throw new \RuntimeException('Failed to encode medical records');
        }

        // Handle diseases as either array or string
        $diseases = $data['diseases'] ?? '';
        if (is_array($diseases)) {
            $diseases = implode(', ', $diseases);
        }

        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO appointments 
                (doctor_id, firstname, lastname, gender, birthdate, appointment_date, medical_records, diseases) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );

            if (!$stmt) {
                throw new \RuntimeException('Prepare failed: ' . $this->conn->error);
            }

            $stmt->bind_param(
                "isssssss",
                $data['doctor_id'],
                $data['firstname'],
                $data['lastname'],
                $data['gender'],
                $data['birthdate'],
                $data['appointment_date'],
                $medicalRecordsJson,
                $diseases
            );

            $result = $stmt->execute();
            
            if (!$result) {
                throw new \RuntimeException('Execute failed: ' . $stmt->error);
            }

            return $result;
        } catch (\mysqli_sql_exception $e) {
            throw new \RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getAppointmentsByDoctor($doctorId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM appointments 
             WHERE doctor_id = ?
             ORDER BY appointment_date DESC"
        );
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $row['medical_records'] = json_decode($row['medical_records'], true) ?? [];
            $row['diseases'] = json_decode($row['diseases'], true) ?? [];
            $appointments[] = $row;
        }
        
        return $appointments;
    }

    public function getAppointmentById($appointmentId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM appointments WHERE id = ?"
        );
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $result['medical_records'] = json_decode($result['medical_records'], true) ?? [];
            $result['diseases'] = json_decode($result['diseases'], true) ?? [];
        }

        return $result;
    }

    public function updateAppointment($appointmentId, $data)
    {
        // Validate input
        if (empty($appointmentId) || !is_numeric($appointmentId)) {
            throw new \InvalidArgumentException('Invalid appointment ID');
        }

        $medicalRecords = $data['medical_records'] ?? [];
        $medicalRecordsJson = json_encode($medicalRecords);
        if ($medicalRecordsJson === false) {
            throw new \RuntimeException('Failed to encode medical records');
        }

        // Handle diseases as either array or string
        $diseases = $data['diseases'] ?? '';
        if (is_array($diseases)) {
            $diseases = implode(', ', $diseases);
        }

        try {
            $stmt = $this->conn->prepare(
                "UPDATE appointments SET
                 firstname = ?,
                 lastname = ?,
                 gender = ?,
                 birthdate = ?,
                 appointment_date = ?,
                 medical_records = ?,
                 diseases = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "sssssssi",
                $data['firstname'],
                $data['lastname'],
                $data['gender'],
                $data['birthdate'],
                $data['appointment_date'],
                $medicalRecordsJson,
                $diseases,
                $appointmentId
            );

            $result = $stmt->execute();
            
            if (!$result) {
                throw new \RuntimeException('Update failed: ' . $stmt->error);
            }

            return $result;
        } catch (\mysqli_sql_exception $e) {
            throw new \RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        return $this->conn->insert_id;
    }

    public function cancelAppointment($appointmentId)
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM appointments WHERE id = ?"
            );
            $stmt->bind_param("i", $appointmentId);
            $result = $stmt->execute();
            
            if (!$result) {
                throw new \RuntimeException('Delete failed: ' . $stmt->error);
            }
            
            return $result;
        } catch (\mysqli_sql_exception $e) {
            throw new \RuntimeException('Database error: ' . $e->getMessage());
        }
    }

    public function getDoctorTimes($doctorId)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT available_time FROM doctor_availability WHERE doctor_id = ?"
            );
            $stmt->bind_param("i", $doctorId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $times = [];
            while ($row = $result->fetch_assoc()) {
                $times[] = $row['available_time'];
            }
            
            return $times;
        } catch (\mysqli_sql_exception $e) {
            throw new \RuntimeException('Database error: ' . $e->getMessage());
        }
    }
}