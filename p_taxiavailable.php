<?php 
require_once './include/header.php';
require_once './auth/session_check.php';
require_once './models/Vehicle.php';
require_once './config/config.php';

// Create Vehicle instance
$vehicle = new Vehicle($pdo);

// Get taxi details statement
$taxiDetailsStmt = $vehicle->getTaxiDetails();
?>

<main class="">
    <!-- Available Vehicles Section -->
    <div class="container py-5">
        <h3 class="text-center mb-4">Available Vehicles</h3>
        <div class="row">
            <?php if ($taxiDetailsStmt): ?>
                <?php while ($taxi = $taxiDetailsStmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="./Img/taxi.png" class="card-img-top" alt="Vehicle">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($taxi['vehicle_model']); ?></h5>
                                <p class="card-text">License Plate: <?php echo htmlspecialchars($taxi['vehicle_plate_no']); ?></p>
                                <p class="card-text">No Of Seat: <?php echo htmlspecialchars($taxi['No_of_Seat']); ?></p>
                                <p class="card-text text-success">
                                    Status: <?php echo $taxi['vehicle_Status']; ?>
                                </p>
                                <?php if ($taxi['vehicle_Status']=='Available'): ?>
                                    <a href="p_booking.php" class="btn btn-clr btn-block">Book Now</a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-clr btn-block disabled">Busy</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-danger">No vehicles available.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once './include/footer.php'; ?>
