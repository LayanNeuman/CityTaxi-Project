<?php

class Login {
    private $pdo;

    // Constructor to initialize the database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Authenticate the user
    public function authenticate($username, $password) {
        // Sanitize user input
        $username = trim($username);
        $password = trim($password);

        // Prepare SQL query to find user by username and password directly
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :username AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and return the result
        if ($user) {
            // Session security: regenerate session ID after successful login
            session_start();
            session_regenerate_id(true);  // Prevent session fixation

            // Store user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            return true;  // Login success
        }

        return false;  // Return false if login failed
    }
}
?>
