<?php
include 'C:/xampp/htdocs/careset/model/UserModel.php'; // Include the UserModel with absolute path

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
                    window.location.href = '../homepage/homepage.php';
                </script>";
                exit();
            } else {
                echo "<script>
                    alert('Invalid email or password.');
                    window.location.href = '../view/user/login.php';
                </script>";
                exit();
            }
        } else {
            include '../view/user/login.php'; // Show the login form if not a POST request
        }
    }

    public function register() { 
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            // Call the model to register the user
            $this->userModel->register($fullname, $email, $password);
            header("Location: ../view/user/login.php"); // Redirect to login page
            exit();
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
}
?>
