<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/careset/model/UserModel.php';


class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $isAuthenticated = $this->userModel->authenticate($email, $password);
            if ($isAuthenticated) {
                echo "<script>
                    alert('Login successful!');
                    window.location.href = '/careset/homepage';
                </script>";
                exit();
            } else {
                echo "<script>
                    alert('Invalid email or password.');
                    window.location.href = '/careset/view/user/login.php';
                </script>";
                exit();
            }
        } else {
            include __DIR__.'/../view/user/login.php'; 
        }
    }

    public function register() { 
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $this->userModel->register($fullname, $email, $password);
            header("Location: /careset/view/user/login.php"); 
            exit();
        } else {
            // Make sure you include the register.php view when not posting
            include __DIR__.'/../view/user/register.php';
        }
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header("Location: ../view/user/login.php");
        exit();
    }

    public function changePicture() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle picture upload
        }
        include '../view/user/changePicture.php';
    }

    public function schedule() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $birthdate = $_POST['birthdate'] ?? '';
            $appointment_date = $_POST['appointment_date'] ?? '';
            $diseases = $_POST['disease'] ?? [];
            
            // Handle multiple file uploads
            if (!empty($_FILES['medical_records'])) {
                $uploadFileDir = 'uploads/';
                if (!file_exists($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                
                foreach ($_FILES['medical_records']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['medical_records']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = basename($_FILES['medical_records']['name'][$key]);
                        $dest_path = $uploadFileDir . $fileName;
                        move_uploaded_file($tmp_name, $dest_path);
                    }
                }
            }

            // Here you would typically call a method to save the appointment details
            // $this->userModel->saveAppointment($firstname, $lastname, $gender, $birthdate, $diseases, $appointment_date);

            echo "<script>
                alert('Appointment scheduled successfully!');
                window.location.href = '/careset/homepage';
            </script>";
            exit();
        } else {
            include __DIR__.'/../view/Schedule/schedule.php';
        }
    }
}
?>
