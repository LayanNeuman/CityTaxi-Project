<?php
require_once './include/header.php';
require_once './config/config.php';
require_once './models/Booking.php';

$booking = new Booking($pdo);
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php"); 
    exit();
}

$passengerId=$_SESSION['user_id'];
if ($passengerId) {
$BookingDetails = $booking->getOngoingBookingDetails($passengerId);
}


if (isset($_POST['bid'])) {
    $bookingId = $_POST['bid']; 
    $vehicleId = $_POST['Vid'];

    if($booking->cancelBooking($bookingId,$vehicleId)){
       // $_SESSION['message'] = 'Booking Canceled Successfully';
    }else{
      //  $_SESSION['message'] = 'Booking Cancellation Failed';
    }
    header("Location: p_bookingongoing.php");
    exit();

} 
?>

<main class="">
     <!-- Cancel Booking Section -->
     <div class="container py-5">
        <h3 class="text-center mb-4">Your Ongoing Bookings</h3>
            <div class="row">

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
                                <p class="card-text">Vehicle Model: <?php echo ($bookingDetails['vehicle_model']); ?></p>
                                <p class="card-text">Vehicle NO: <?php echo ($bookingDetails['vehicle_plate_no']); ?></p>
                                <p class="card-text">Driver Name<?php echo ($bookingDetails['pickup_location']); ?></p>
                                <p class="card-text">Pickup Location: <?php echo ($bookingDetails['pickup_location']); ?></p>
                                <p class="card-text">Drop-off Location: <?php echo ($bookingDetails['dropoff_location']); ?></p>
                                <p class="card-text">Date: <?php echo (date('Y-m-d', strtotime($bookingDetails['pickup_time']))); ?></p>
                                <p class="card-text">Time: <?php echo (date('h:i A', strtotime($bookingDetails['pickup_time']))); ?></p>
                                <p class="card-text text-success">Status: <?php echo ($bookingDetails['status']); ?></p>
                                <?php if($bookingDetails['status']=='Pending'):?>
                                <!-- Form to Cancel Booking -->
                                <form action="p_bookingongoing.php" method="POST">
                                    <input type="hidden" name="bid" value="<?php echo ($bookingDetails['bid']); ?>">
                                    <input type="hidden" name="Vid" value="<?php echo ($bookingDetails['vehicle_id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-block">Cancel Booking</button>
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