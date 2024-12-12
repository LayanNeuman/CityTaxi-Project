<?php
require_once './include/header.php';
require_once './config/config.php';
require_once './models/Booking.php';

$booking = new Booking($pdo);
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php"); 
    exit();
}


$BookingDetails = $booking->getBookingRequest();



if (isset($_POST['st-pickup'])) {
    $bookingId = $_POST['bid']; 
    if($booking->BookingPickup($bookingId)){
    }else{}
    header("Location: d_Driverrequest.php");
    exit();
} 

if (isset($_POST['st-drop'])) {
    $bookingId = $_POST['bid']; 
    $vehicleId = $_POST['Vid'];
    if($booking->BookingDrop($bookingId,$vehicleId)){
    }else{}
    header("Location: d_Driverrequest.php");
    exit();
} 
?>

<main class="">
     <!-- Cancel Booking Section -->
     <div class="container py-5">
        <h3 class="text-center mb-4">To Be Bookings</h3>
            <div class="row justify-content-center">

                     <div class="col-12">
                     <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                     </div>

                <!---->
                <?php if (isset($BookingDetails['success']) && $BookingDetails['success']): ?>
                <?php foreach ($BookingDetails['data'] as $bookingDetails): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Booking #<?php echo ($bookingDetails['bid']); ?></h5>
                                <p class="card-text">Passenger Name: <?php echo ($bookingDetails['username']); ?></p>
                                <p class="card-text">Contact NO: <?php echo ($bookingDetails['ContactNO']); ?></p>
                                <p class="card-text">Pickup Location: <?php echo ($bookingDetails['pickup_location']); ?></p>
                                <p class="card-text">Drop-off Location: <?php echo ($bookingDetails['dropoff_location']); ?></p>
                                <p class="card-text">Pickup Date: <?php echo (date('Y-m-d', strtotime($bookingDetails['pickup_time']))); ?></p>
                                <p class="card-text">Pickup Time: <?php echo (date('h:i A', strtotime($bookingDetails['pickup_time']))); ?></p>
                                <p class="card-text text-success">Status: <?php echo ($bookingDetails['status']); ?></p>
                                <?php if($bookingDetails['status']=='Pending'):?>
                                <!-- Form to Cancel Booking -->
                                <form action="d_Driverrequest.php" method="POST">
                                    <input type="hidden" name="bid" value="<?php echo ($bookingDetails['bid']); ?>">
                                    <button type="submit" name="st-pickup" class="btn btn-success btn-block">Pickup</button>
                                </form>
                                <?php elseif ($bookingDetails['status']=='Confirmed'):?>
                                 <form action="d_Driverrequest.php" method="POST">
                                    <input type="hidden" name="bid" value="<?php echo ($bookingDetails['bid']); ?>">
                                    <input type="hidden" name="Vid" value="<?php echo ($bookingDetails['vehicle_id']); ?>">
                                    <button type="submit" name="st-drop" class="btn btn-primary btn-block">Drop</button>
                                </form>
                                <?php else:?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-danger"><?php echo isset($BookingDetails['message']) ? htmlspecialchars($BookingDetails['message']) : 'No ongoing bookings found.'; ?></p>
                </div>
            <?php endif; ?>
                <!---->
        </div>
    </div>
</main>
<?php include './include/footer.php'?>