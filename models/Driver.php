<?php 
require_once './util/mail.php';
class Driver {
    private $pdo;
    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new user
    public function registerDriver($email, $username, $contactNo) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = 'Invalid email format.';
             return;
        }

        // Generate a random password
        $AutoPassword = new AutoPassword();
        $password =$AutoPassword->generatePassword(8);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userType='D';

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
                $driverId = $this->pdo->lastInsertId();
                $mailer = new Mailer();
                $mailer->sendMail($username,$email,$password);
                header("Location: vehicleregister.php?id=" . urlencode($driverId));
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

