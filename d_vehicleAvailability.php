<?php 
require_once './include/header.php';
require_once './models/Vehicle.php';
require_once './config/config.php';
$vehicle = new Vehicle($pdo);
$vehicleDetails = $vehicle->getVehicleDetails();


if (isset($_POST['st-busy'])) {
    $vid = $_POST['vid']; 
        if($vehicle->vehicleDeActivate($vid)){
         //   $_SESSION['message'] = 'Booking Canceled Successfully';
            header("Location: d_vehicleAvailability.php");
            exit();
        }else{
          //  $_SESSION['message'] = 'Booking Cancellation Failed';
            header("Location: d_vehicleAvailability.php");
            exit();
        }
} 

if (isset($_POST['st-av'])) {
    $vid = $_POST['vid']; 
        if($vehicle->vehicleActivate($vid)){
         //   $_SESSION['message'] = 'Booking Canceled Successfully';
            header("Location: d_vehicleAvailability.php");
            exit();
        }else{
          //  $_SESSION['message'] = 'Booking Cancellation Failed';
            header("Location: d_vehicleAvailability.php");
            exit();
        }
} 
?>
<main class="">

   <!-- Driver Vehicle Registration Section -->
   <div class="container py-5">
        <h3 class="text-center mb-4">Your Vehicle Information</h3>
        <div class="card p-4 shadow" style="max-width: 600px; margin: 0 auto;">
            <h4 class="card-title ">Vehicle Details</h4>
                <?php if ($vehicleDetails): ?>
                    <p class="card-text">Vehicle Make: <?php echo htmlspecialchars($vehicleDetails['vehicle_model']); ?></p>
                    <p class="card-text">License Plate: <?php echo htmlspecialchars($vehicleDetails['vehicle_plate_no']); ?></p>
                    <p class="card-text">No of Seats: <?php echo htmlspecialchars($vehicleDetails['No_of_Seat']); ?></p>
                    <p class="card-text">Status: 
                        <?php
                        $vsts=$vehicleDetails['vehicle_availability'];
                     if($vsts==0){
                        echo "Deactivate";
                     }else{
                        echo "Activate";
                     }; ?></p>
                    
                    <?php if ($vehicleDetails['vehicle_availability'] == false): ?>
                        <form action="d_vehicleAvailability.php" method="POST">
                             <input type="hidden" name="vid" value="<?php echo ($vehicleDetails['id']); ?>">
                          <button class="btn btn-success btn-block" name="st-av">Available</button>
                        </form>
                    <?php else: ?>
                        <form action="d_vehicleAvailability.php" method="POST">
                       <!-- <a href="#" class="btn btn-danger btn-block">Busy</a>-->
                         <input type="hidden" name="vid" value="<?php echo htmlspecialchars($vehicleDetails['id']); ?>">
                        <button class="btn btn-danger btn-block" name="st-busy">Busy</button>
                        </form>
                    <?php endif; ?>
                    <?php else: ?>
                        <p class="card-text text-danger">Vehicle not found.</p>
                    <?php endif; ?>
        </div>
    </div>

</main>
<?php include './include/footer.php'?>