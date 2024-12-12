<?php
class Booking {
    private $pdo;

    // Constructor to establish a database connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function checkpendingBooking($passengerId) {
        try {
            $Pending="Pending";
            $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE passenger_id = :passenger_id AND status = :status");
            $stmt->bindParam(':passenger_id', $passengerId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $Pending, PDO::PARAM_STR); // Fix binding for string 'Pending'
            $stmt->execute();
    
            $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Check if any rows were returned
            return count($bookingDetails) > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    

    // Method to create a new booking
    public function createBooking($passengerId, $vehicleId, $pickupLocation, $dropoffLocation, $pickupTime, $dropoffTime, $distanceKm, $cost, $status = 'Pending') {
        if (empty($passengerId) || empty($pickupLocation) || empty($dropoffLocation) || empty($pickupTime) || empty($distanceKm) || empty($cost)) {
            //return ['success' => false, 'message' => 'All fields must be provided'];
            $_SESSION['message'] = 'All fields must be provided'; 
            header("Location: P_booking.php"); // Redirect back to booking page
            exit();
        }
        elseif($this->checkpendingBooking($passengerId)){
            $_SESSION['message'] = 'A booking is already pending. Please complete or cancel the current booking before proceeding with a new one'; 
            header("Location: P_booking.php"); 
            exit();
        }
        
        elseif($vehicleId==0 ||empty($vehicleId)) {
            $_SESSION['message'] = 'Vehicle Not avilable'; 
            header("Location: P_booking.php"); 
            exit();
        }else
            try {
                $this->pdo->beginTransaction();
    
    
                  // Insert into bookings table
                $stmt = $this->pdo->prepare("INSERT INTO bookings (passenger_id, vehicle_id, pickup_location, dropoff_location, pickup_time, dropoff_time, distance_km, cost, status) 
                                              VALUES (:passenger_id, :vehicle_id, :pickup_location, :dropoff_location, :pickup_time, :dropoff_time, :distance_km, :cost, :status)");
    
                // Bind parameters
                $stmt->bindParam(':passenger_id', $passengerId);
                $stmt->bindParam(':vehicle_id', $vehicleId);
                $stmt->bindParam(':pickup_location', $pickupLocation);
                $stmt->bindParam(':dropoff_location', $dropoffLocation);
                $stmt->bindParam(':pickup_time', $pickupTime);
                $stmt->bindParam(':dropoff_time', $dropoffTime);
                $stmt->bindParam(':distance_km', $distanceKm);
                $stmt->bindParam(':cost', $cost);
                $stmt->bindParam(':status', $status);
    
                // Execute the statement
                if ($stmt->execute()) {
                   // return ['success' => true, 'message' => 'Booking created successfully!'];
                   $stmt2 = $this->pdo->prepare("UPDATE vehicles SET vehicle_Status = 'Busy' WHERE id = :vehicle_id");
                   $stmt2->bindParam(':vehicle_id', $vehicleId);
                   if ($stmt2->execute()) {
                    // Commit the transaction
                    $this->pdo->commit();
                    return ['success' => true, 'message' => 'Booking created and vehicle status updated successfully!'];
                    } else {
                        // Roll back if the vehicle update fails
                        $this->pdo->rollBack();
                        return ['success' => false, 'message' => 'Failed to update vehicle status.'];
                    }
    
                } else {
                    return ['success' => false, 'message' => 'Failed to create booking.'];
                }
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
    }

    public function getOngoingBookingDetails($passengerId) {
        try {
            // Prepare the SQL statement to fetch booking details for the specific passenger
            $stmt = $this->pdo->prepare("SELECT
                                            bookings.bid,
                                            bookings.passenger_id,
                                            users.email,
                                            users.username,
                                            users.ContactNO,
                                            bookings.vehicle_id,
                                            vehicles.vehicle_model,
                                            vehicles.vehicle_plate_no,
                                            bookings.pickup_location,
                                            bookings.dropoff_location,
                                            bookings.pickup_time,
                                            bookings.dropoff_time,
                                            bookings.distance_km,
                                            bookings.cost,
                                            bookings.status,
                                            bookings.created_at,
                                            bookings.updated_at
                                        FROM 
                                            bookings
                                        INNER JOIN 
                                            users ON bookings.passenger_id = users.id
                                        INNER JOIN 
                                            vehicles ON bookings.vehicle_id = vehicles.id
                                        WHERE 
                                            bookings.passenger_id = :passenger_id  AND status = 'Pending' OR status = 'Confirmed' "); // Use :passenger_id here
                                            
            // Bind the passenger ID correctly
            $stmt->bindParam(':passenger_id', $passengerId, PDO::PARAM_INT); // Use :passenger_id here
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch all booking details as an associative array
            $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Check if any booking details were found
            if ($bookingDetails) {
                return ['success' => true, 'data' => $bookingDetails]; // Return the booking details
            } else {
                return ['success' => false, 'message' => 'No bookings found for this passenger.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; // Return error message
        }
    }





 //--------------------------------------------------------------------------------------------------------------
    //Booking Cancel
    public function cancelBooking($bid, $vehicleId) {
        $bookingID=$bid;
        $Vid=$vehicleId;
        try {
            $query = "UPDATE bookings SET status = 'Dropped' WHERE bid = :bid AND status = 'Pending'";
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute([
                "bid" => $bookingID,
            ]);

            if($result){
                $query2 = "UPDATE vehicles SET vehicle_status = 'Available' WHERE id = :vehicle_id";
                $statement2 = $this->pdo->prepare($query2);
                $Result2 = $statement2->execute([
                    "vehicle_id" => $Vid,
                ]);
                return true;
            }
            else{
                return false;
            }
           
        } catch (PDOException $e) {
            error_log("Error adding record: " . $e->getMessage());
            return false;
        }
    }
    


    
    
 // Booking History
    public function getBookingHistory($passengerId) {
        try {
            
            $stmt = $this->pdo->prepare("SELECT
                                            bookings.bid,
                                            bookings.passenger_id,
                                            users.email,
                                            users.username,
                                            users.ContactNO,
                                            bookings.vehicle_id,
                                            vehicles.vehicle_model,
                                            vehicles.vehicle_plate_no,
                                            vehicles.No_of_Seat,
                                            bookings.pickup_location,
                                            bookings.dropoff_location,
                                            bookings.pickup_time,
                                            bookings.dropoff_time,
                                            bookings.distance_km,
                                            bookings.cost,
                                            bookings.pay,
                                            bookings.status,
                                            bookings.created_at,
                                            bookings.updated_at
                                        FROM 
                                            bookings
                                        INNER JOIN 
                                            users ON bookings.passenger_id = users.id
                                        INNER JOIN 
                                            vehicles ON bookings.vehicle_id = vehicles.id
                                        WHERE 
                                            bookings.passenger_id = :passenger_id 
                                            AND bookings.status = 'Completed';
                                        "); 
                                            
            $stmt->bindParam(':passenger_id', $passengerId, PDO::PARAM_INT); 
            $stmt->execute();
        
            $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if ($bookingDetails) {
                return ['success' => true, 'data' => $bookingDetails]; 
            } else {
                return ['success' => false, 'message' => 'No bookings found for this passenger.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; 
        }
    }

    //Booking Payment
     public function BookingPayment($BookID, $ammount) {
        $BookID=$BookID;
        $ammount=$ammount;
        try {
            $query = "UPDATE bookings SET pay = :pay WHERE bid = :bid ";
            $statement = $this->pdo->prepare($query);
            $result = $statement->execute([
                "bid" => $BookID,
                "pay" => $ammount,
            ]);
                return true;
            }
         catch (PDOException $e) {
            error_log("Error adding record: " . $e->getMessage());
            return false;
        }
    }


    //Show all service Request

    
    public function getBookingRequest() {
        $DriverId=$_SESSION['user_id'];
        try {

                        // Prepare the SQL statement to fetch booking details for the specific passenger
                        $stmt = $this->pdo->prepare("SELECT
                        bookings.bid,
                        bookings.passenger_id,
                        users.email,
                        users.username,
                        users.ContactNO,
                        bookings.vehicle_id,
                        vehicles.vehicle_model,
                        vehicles.Driver,
                        vehicles.vehicle_plate_no,
                        bookings.pickup_location,
                        bookings.dropoff_location,
                        bookings.pickup_time,
                        bookings.dropoff_time,
                        bookings.distance_km,
                        bookings.cost,
                        bookings.status,
                        bookings.created_at,
                        bookings.updated_at
                    FROM 
                        bookings
                    INNER JOIN 
                        users ON bookings.passenger_id = users.id
                    INNER JOIN 
                        vehicles ON bookings.vehicle_id = vehicles.id
                    WHERE 
                         vehicles.Driver = :Driver  AND status = 'Pending' OR status='Confirmed'");
              
            // Bind the passenger ID correctly
            $stmt->bindParam(':Driver', $DriverId, PDO::PARAM_INT);
            $stmt->execute();
            $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($bookingDetails) {
            return ['success' => true, 'data' => $bookingDetails]; 
            } else {
            return ['success' => false, 'message' => 'No bookings found for this passenger.'];
            }

           
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; 
        }
    }

    //Booking Pickup
  public function BookingPickup($bid) {
    $bookingID=$bid;
    try {
        $query = "UPDATE bookings SET status = 'Confirmed' WHERE bid = :bid AND status = 'Pending'";
        $statement = $this->pdo->prepare($query);
        $result = $statement->execute([
            "bid" => $bookingID,
        ]);

            return true;
       
    } catch (PDOException $e) {
        error_log("Error adding record: " . $e->getMessage());
        return false;
    }
}

   //Booking Drroped
   public function BookingDrop($bid,$vehicleId) {
    $bookingID=$bid;
    $Vid=$vehicleId;
    try {
        $query = "UPDATE bookings SET status = 'Completed' WHERE bid = :bid AND status = 'Confirmed'";
        $statement = $this->pdo->prepare($query);
        $result = $statement->execute([
            "bid" => $bookingID,
        ]);

        if($result){
            $query2 = "UPDATE vehicles SET vehicle_status = 'Available' WHERE id = :vehicle_id";
            $statement2 = $this->pdo->prepare($query2);
            $Result2 = $statement2->execute([
                "vehicle_id" => $Vid,
            ]);
            return true;
        }
        else{
            return false;
        }

        return false;
       
    } catch (PDOException $e) {
        error_log("Error adding record: " . $e->getMessage());
        return false;
    }
}



 // Driver History
 public function getBookingHistoryDriver($passengerId) {
    try {
        
        $stmt = $this->pdo->prepare("SELECT
                                        bookings.bid,
                                        bookings.passenger_id,
                                        users.email,
                                        users.username,
                                        users.ContactNO,
                                        bookings.vehicle_id,
                                        vehicles.vehicle_model,
                                        vehicles.vehicle_plate_no,
                                        vehicles.No_of_Seat,
                                        vehicles.Driver,
                                        bookings.pickup_location,
                                        bookings.dropoff_location,
                                        bookings.pickup_time,
                                        bookings.dropoff_time,
                                        bookings.distance_km,
                                        bookings.cost,
                                        bookings.pay,
                                        bookings.status,
                                        bookings.created_at,
                                        bookings.updated_at
                                    FROM 
                                        bookings
                                    INNER JOIN 
                                        users ON bookings.passenger_id = users.id
                                    INNER JOIN 
                                        vehicles ON bookings.vehicle_id = vehicles.id
                                    WHERE 
                                    vehicles.Driver = :Driver 
                                        AND bookings.status = 'Completed';
                                    "); 
                                        
        $stmt->bindParam(':Driver', $passengerId, PDO::PARAM_INT); 
        $stmt->execute();
    
        $bookingDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($bookingDetails) {
            return ['success' => true, 'data' => $bookingDetails]; 
        } else {
            return ['success' => false, 'message' => 'No bookings found for this passenger.'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()]; 
    }
}


}
?>
