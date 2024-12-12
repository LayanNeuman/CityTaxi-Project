<?php 
require_once './include/header.php';
require_once './models/passenger.php';
require_once './models/AutoPwd.php';
require_once './config/config.php';

$passenger = new passenger($pdo);
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data with validation
    $email = $_POST['email'] ?? '';
    $fullName = $_POST['fullname'] ?? ''; 
    $contactNo = $_POST['contactno'] ?? ''; 
    $passenger->registerPassenger($email, $fullName, $contactNo);

    // Redirect to the dashboard or back to the form based on your preference
 //   header("Location: Home.php");
  //  exit();
}
?>

<main class="bg-main">
    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Passanger Register</h3>
                  <?php 
                        // Display error message if available
                        if (isset($_SESSION['message'])) {
                            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['message'] . '</div>';
                            unset($_SESSION['message']); // Clear the message after displaying it
                        }
                  ?>  
            <form action="Passregister.php" method="POST"> 
                <div class="form-group txt-br">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group txt-br">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname" required>
                </div>
                <div class="form-group txt-br">
                    <label for="contactno">Contact NO</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Contact NO" required>
                </div>
                <button type="submit" class="btn btn-clr btn-block">Register</button>
            </form>
            <p class="text-center mt-3">
                <a href="./login.php" ><button type="" class="btn btn-clrout btn-block ">Login</button></a>
            </p>
        </div>
    </div>
</main>
<?php include './include/footer.php'?>