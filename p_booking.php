<?php 
require_once './include/header.php';
require_once './config/config.php';
require_once './models/Booking.php';
require_once './models/Vehicle.php';

$booking = new Booking($pdo);
$vehicle = new Vehicle($pdo);
$vehicleDetails = $vehicle->getTaxi();
$TaxiId = $vehicleDetails['id']??0;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); 
        exit();
    }

    // Capture form data
    $passengerId = $_SESSION['user_id']; // Get passenger ID from session
    $pickupLocation = $_POST['hidden_pickup']; // Use hidden input for pickup
    $dropoffLocation = $_POST['hidden_dropoff']; // Use hidden input for dropoff
    $pickupTime = date('Y-m-d H:i:s'); // Current time
    $dropoffTime = null; // Optional
    $distanceKm = 10; // Total distance
    $cost = $_POST['cost']; // Total cost

     // Check if pickup or dropoff locations are empty
     if (empty($pickupLocation) || empty($dropoffLocation)) {
        $_SESSION['message'] = 'Pickup and drop-off locations must be provided.'; // Set session message
        header("Location: p_booking.php"); // Redirect back to booking page
        exit();
    }

    // Create booking
    $result = $booking->createBooking($passengerId, $TaxiId, $pickupLocation, $dropoffLocation, $pickupTime, $dropoffTime, $distanceKm, $cost);

    // Handle the result
    if ($result['success']) {
        header("Location: p_bookingongoing.php"); // Redirect to success page
        exit();
    } else {
        echo $result['message']; // Show error message
    }
}
?>

<main class="">
   <!-- Booking Form -->
   <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%;">
            <h3 class="text-center mb-4">Book Your Ride</h3>
            <div class="error">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($_SESSION['message']); ?>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
            </div>
            <form action="p_booking.php" method="POST">
                <gmpx-api-loader key="AIzaSyCrTqJOEyNjvKHmYhVxOTtlH7FcTFBYfUA" solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 place-picker-container">
                            <gmpx-place-picker id="pickup" name="pickup_location" placeholder="Enter pickup location"></gmpx-place-picker>
                            <input type="hidden" name="hidden_pickup" id="hiddenPickup" value="">
                        </div>

                        <div class="col-md-6 place-picker-container">
                            <gmpx-place-picker id="dropoff" name="dropoff_location" placeholder="Enter drop-off location"></gmpx-place-picker>
                            <input type="hidden" name="hidden_dropoff" id="hiddenDropoff" value="">
                        </div>
                    </div>
                    <gmp-map center="40.749933,-73.98633" zoom="13" map-id="DEMO_MAP_ID">
                        <gmp-advanced-marker></gmp-advanced-marker>
                    </gmp-map>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Total KM</h4>
                            <p id="totalDistance">20 km</p>
                            <h4>Total Amount</h4>
                            <p id="totalAmount">1500.00</p>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="distance_km" id="distance_km" value="0">
                            <input type="hidden" name="cost" id="cost" value="1500.00">
                            <button type="submit" class="btn btn-clr btn-block mt-5 pt-3">Confirm Booking</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="./map.js"></script>
    <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
</main>
<?php include './include/footer.php'; ?>
