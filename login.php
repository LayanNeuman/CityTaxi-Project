<?php
require_once './include/header.php';
require_once 'auth/authenticate.php'; 
require_once './config/config.php';


$login = new Login($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($login->authenticate($email, $password)) {
        switch ($_SESSION['user_type']) {
            case 'A':
                header("Location: Admin/index.php");
                exit();
            case 'O':
                header("Location: Admin/Booking.php");
                exit();
            default:
                header("Location: index.php");
                exit();
        }
    }

    else {
        header("Location: login.php"); 
        exit();
    } 
}

?>
<main class="bg-main">
    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login to City Taxi</h3>
                    <?php 
                        if (isset($_SESSION['message'])) {
                            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['message'] . '</div>';
                            unset($_SESSION['message']);
                        }
                    ?> 
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-clr btn-block">Login</button>
            </form>
            <p class="text-center mt-3">
                <a href="#">Forgot your password?</a>
            </p>
            <p class="text-center">
                Don’t have an account? <a href="register.php">Sign up here</a>
            </p>
        </div>
    </div>
</main>
<?php include './include/footer.php'?>