<?php


class Login {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to authenticate user credentials
    public function authenticate($email, $password) {
        try {
            // Select user details from the database
            $stmt = $this->pdo->prepare("SELECT id, username, email, password, user_type FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Fetch user details
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify user exists and password matches
            if ($user && password_verify($password, $user['password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];

                return true; // Return true on successful login
            } else {
                $_SESSION['message'] = 'Invalid email or password.';
                return false; // Return false on failed login
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            return false; // Return false on error
        }
    }
}
?>
