<?php 
class Vehicle {
    private $pdo;

    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create/register a new vehicle
    public function registerVehicle($model, $plateNo, $seats,$driverId) {
        // Validate the inputs
            if (empty($model) || empty($plateNo) || !is_numeric($seats)){
            return ['success' => false, 'message' => 'Invalid input provided.'];}
        

        // Default values for the vehicle's status and availability
        $vehicleStatus = 'Available';
        $vehicleAvailability = true;
        // Prepare the SQL statement
        try {
            $stmt = $this->pdo->prepare("INSERT INTO vehicles (Driver, vehicle_model, vehicle_plate_no, No_of_Seat,vehicle_Status, vehicle_availability) 
                                         VALUES (:Driver, :vehicle_model, :vehicle_plate_no, :No_of_Seat,:vehicle_Status, :vehicle_availability)");
            //VALUES (:model, :plateNo, :seats, :vehicleStatus, :vehicleAvailability)"
            // Execute the statement with provided parameters
            $stmt->execute([
                'Driver' => $driverId,
                'vehicle_model' => $model,
                'vehicle_plate_no' => $plateNo,
                'No_of_Seat' => $seats,
                'vehicle_Status' => $vehicleStatus,
                'vehicle_availability' => $vehicleAvailability
            ]);

            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {

                header("Location: login.php"); 
                exit();
            } else {

            }
        } catch (PDOException $e) {

        }
    }

  
    /*-----------------------*/

    public function getVehicleDetails() {
        $DriverId=$_SESSION['user_id'];
        try {
            $stmt = $this->pdo->prepare("SELECT id, vehicle_model, vehicle_plate_no, No_of_Seat, vehicle_availability FROM vehicles WHERE Driver = :Driver");
            $stmt->execute(['Driver' =>$DriverId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false; // Or handle the error as needed
        }
    }

    public function getTaxiDetails() {
        try {
            $stmt = $this->pdo->prepare("SELECT vehicle_model, vehicle_plate_no, No_of_Seat,vehicle_Status, vehicle_availability FROM vehicles WHERE vehicle_Status='Available' AND  vehicle_availability=:RES");
            $stmt->execute(['RES' =>'1']);
            return $stmt; // Return the statement for later use
        } catch (PDOException $e) {
            return false; // Handle the error as needed
        }
    }

    public function getTaxi() {
        try {
            // Select a random taxi from the vehicles table
            $stmt = $this->pdo->prepare("SELECT id, vehicle_model, vehicle_plate_no, No_of_Seat FROM vehicles  where vehicle_Status ='Available' AND vehicle_availability='1' ORDER BY RAND() LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single random taxi
        } catch (PDOException $e) {
            return false; // Handle the error as needed
        }
    }
    
    //----updateTaxiStatus---//
    public function updateVehicleStatus($TaxiID,$Status){

    }



    public function vehicleDeActivate($Vid) {
        $Vid=$Vid;
        try {
            $query = "UPDATE vehicles SET vehicle_availability ='0' WHERE id = :id ";
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute([
                "id" => $Vid,
            ]);
                return true;
            }
         catch (PDOException $e) {
            error_log("Error adding record: " . $e->getMessage());
            return false;
        }
    }

    public function vehicleActivate($Vid) {
        $Vid=$Vid;
        try {
            $query = "UPDATE vehicles SET vehicle_availability ='1' WHERE id = :id ";
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute([
                "id" => $Vid,
            ]);
                return true;
            }
         catch (PDOException $e) {
            error_log("Error adding record: " . $e->getMessage());
            return false;
        }
    }

}
?>
