<?php 
require_once './include/header.php';
require_once './models/Vehicle.php';
require_once './config/config.php';

// Check if 'id' is set in the query string and retrieve it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $driverId = (int) $_GET['id']; // Ensure driverId is an integer
} else {
    // Redirect to Driver registration if 'id' is not set or not numeric
    header("Location: Driverregister.php");
    exit();
}

$vehicle = new Vehicle($pdo);
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_model = $_POST['vehicle_model']?? '';
    $vehicle_plate_no = $_POST['vehicle_plate_no']?? '';
    $seats = isset($_POST['seats']) ? (int) $_POST['seats'] : 0;
    $driverId = (int) $_POST['ID']?? '';
    $vehicle->registerVehicle($vehicle_model, $vehicle_plate_no, $seats,$driverId);

    // Redirect to the dashboard or back to the form based on your preference
 //   header("Location: Home.php");
  //  exit();
}
?>

<main class="bg-main">
    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4"><i class="fas fa-taxi"></i>Vehicle Update</h3>

            <form action="vehicleregister.php?id=<?php echo htmlspecialchars($driverId); ?>" method="POST">
                <div class="form-group ">
                <input type="hidden" name="ID" value="<?php echo htmlspecialchars($driverId); ?>">
                    <input type="text" class="form-control" id="email" name="vehicle_model" placeholder="Vehicle Model" required>
                </div>
                <div class="form-group ">
                    <input type="text" class="form-control" id="password" name="vehicle_plate_no" placeholder="Vehicle Plate No" required>
                </div>
                <div class="form-group ">
                    <input type="text" class="form-control" id="password" name="seats" placeholder="No Of Seat" required>
                </div>

                <div class="custom-file mb-2 ">
                    <input type="file" class="custom-file-input" id="fileInput" >
                    <label class="custom-file-label" for="fileInput">Vehicle Book</label>
                    <p class="file-name" id="fileName"></p>
                </div>

                <div class="custom-file mb-2 txt-br">
                    <input type="file" class="custom-file-input" id="fileInput" >
                    <label class="custom-file-label" for="fileInput">Vehicel Photo</label>
                    <p class="file-name" id="fileName"></p>
                </div>

                <button type="submit" class="btn btn-clr btn-block ">Save</button>
            </form>

        </div>
    </div>
</main>
<?php include './include/footer.php'?>