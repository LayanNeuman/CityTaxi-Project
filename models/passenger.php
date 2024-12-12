<?php 
require_once './util/mail.php';
class passenger {
    private $pdo;
    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new user
    public function registerPassenger($email, $username, $contactNo) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        // Generate a random password
        $AutoPassword = new AutoPassword();
        $password =$AutoPassword->generatePassword(8);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userType='P';

        // Prepare the SQL statement
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (email, username, user_type,password,ContactNO) VALUES (:email, :username, :user_type,:password,:ContactNO)");
            $stmt->execute([
                'email' => $email,
                'username' => $username,
                'user_type' => $userType,
                'ContactNO' => $contactNo,
                'password' => $hashedPassword,
            ]);

            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                $mailer = new Mailer();
                $mailer->sendMail($username,$email,$password);
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['message'] = 'Failed to create user.';
            }
        } catch (PDOException $e) {
           // Check for duplicate entry error
                 if ($e->getCode() == 23000) {
                    $_SESSION['message'] = 'Email already has an account.';
                }
                else {
                    $_SESSION['message'] = 'Error: ' . $e->getMessage();
                }
        }
    }

}
?>

