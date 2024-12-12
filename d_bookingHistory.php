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
$BookingDetails = $booking->getBookingHistoryDriver($passengerId);
}
?>
<main class="">
    <div class="container py-5">
        <h3 class="text-center mb-4">Your Bookings History</h3>
            <div class="row">
                <!---->
                <?php if (isset($BookingDetails['success']) && $BookingDetails['success']): ?>
                <?php foreach ($BookingDetails['data'] as $bookingDetails): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Booking #<?php echo htmlspecialchars($bookingDetails['bid']); ?></h5>
                                <p class="card-text">Pickup Location: <?php echo htmlspecialchars($bookingDetails['pickup_location']); ?></p>
                                <p class="card-text">Drop-off Location: <?php echo htmlspecialchars($bookingDetails['dropoff_location']); ?></p>
                                <p class="card-text">Date: <?php echo htmlspecialchars(date('Y-m-d', strtotime($bookingDetails['pickup_time']))); ?></p>
                                <p class="card-text text-success">Ammount: <?php echo 'Rs.'.htmlspecialchars($bookingDetails['cost']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
                <!---->
        </div>
    </div>

</main>
<?php include './include/footer.php'?>