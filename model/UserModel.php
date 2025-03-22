<?php
class UserModel {
    private $conn;

    public function __construct() {
        include 'C:/xampp/htdocs/careset/database/db.php'; // Include database connection with absolute path
        $this->conn = $conn;
    }

    public function authenticate($email, $password) {
        // Logic to authenticate user
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return password_verify($password, $user['password']); // Verify the password
        }
        return false; // Return false if no user found
    }

    public function register($fullname, $email, $password) {
        // Logic to register user
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        if (!$stmt) {
            die("Database prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $fullname, $email, $hashedPassword); // Use hashed password
        if (!$stmt->execute()) {
            die("Database execution failed: " . $stmt->error);
        }
    }
}
?>
