<?php 
require_once '../util/mail.php';
class User {
    private $pdo;
    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new user
    public function createUser($email, $username, $userType) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        // Generate a random password
        $AutoPassword = new AutoPassword();
        $password =$AutoPassword->generatePassword(8);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (email, username, user_type,password) VALUES (:email, :username, :user_type,:password)");
            $stmt->execute([
                'email' => $email,
                'username' => $username,
                'user_type' => $userType,
                'password' => $hashedPassword,
            ]);

            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                $mailer = new Mailer();
                $mailer->sendMail($username,$email,$password);
                $_SESSION['message'] = 'User created successfully!';
                $_SESSION['msg_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to create user.';
                $_SESSION['msg_type'] = 'error';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            $_SESSION['msg_type'] = 'error';
        }
    }



      // Method to get all user data
      public function getData() {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, email,user_type FROM users");
            $stmt->execute();

            // Fetch all rows as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any exceptions
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function deleteUser($id) {
        try {
            // Prepare the DELETE statement
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['message'] = 'User deleted successfully!';
                $_SESSION['msg_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to delete user.';
                $_SESSION['msg_type'] = 'error';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            $_SESSION['msg_type'] = 'error';
        }
    }

}
?>

