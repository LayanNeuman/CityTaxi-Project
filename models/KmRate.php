<?php

class RateClass {
    private $pdo;

    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to update the kmRate
    public function updateKmRate($kmRate) {
        // Validate the input
        if (!is_numeric($kmRate)) {
            return ['success' => false, 'message' => 'Invalid kmRate.'];
        }

        try {
            // Prepare the SQL statement to update the kmRate
            $stmt = $this->pdo->prepare("UPDATE taxi_rates SET kmRate = :kmRate where id='3'"); // Adjust the table name and condition
            $stmt->execute(['kmRate' => $kmRate]);

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                header('Location:kmrate.php');
                exit;
            } else {
                return ['success' => false, 'message' => 'No changes made or record not found.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Update failed: ' . $e->getMessage()];
        }
    }
    //-------------------------------------------------------------------------------------------------------------------------------------//
     // Method to get the current kmRate
     public function getKmRate() {
        try {
            $stmt = $this->pdo->prepare("SELECT kmRate FROM taxi_rates where id='3'"); 
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return false;   
        }
    }
}
?>
