<?php
session_start(); 
$user_type = $_SESSION['user_type'] ?? '';
$username = $_SESSION['username'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>City Taxi</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./map.css">

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <img src="./Img/Logo.png" alt="City Taxi Logo" width="40" height="40" class="d-inline-block align-middle">
            City Taxi
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">&#9776;</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <!--passanger-->
                <?php if ($user_type === 'P'): // Passenger Links ?>
                <li class="nav-item">
                    <a class="nav-link" href="p_booking.php">Booking</a>
                </li>
                
                 <li class="nav-item">
                    <a class="nav-link" href="p_taxiavailable.php">Taxi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="p_bookingongoing.php">On Going</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="p_bookingHistory.php">Booking History</a>
                </li>


                <?php elseif ($user_type === 'D'): // Driver Links ?>
                <li class="nav-item">
                    <a class="nav-link" href="d_Driverrequest.php">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="d_vehicleAvailability.php">Availability</a>
                </li>
                 <!--  <li class="nav-item">
                 <a class="nav-link" href="bookingongoing.php">On Going</a>
                </li>-->

                <li class="nav-item">
                    <a class="nav-link" href="d_bookingHistory.php">Trip History</a>
                </li>
                <?php endif; ?>
                <?php if (!empty($username)): // If logged in ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!--<a class="dropdown-item" href="#">Account</a>-->
                        <a class="dropdown-item" href="./auth/logout.php">Logout</a>
                    </div>
                </li> 
                <?php else: ?> <?php endif; ?>    

                <?php if (empty($username)): // If not logged in ?>
                <li class="nav-item btn-lst">
                    <a class="btn btn-custom" href="login.php">Login</a>
                </li>
                <?php else: // Welcome message for logged in users ?>
                    <li class="nav-item">
                        <span class="btn btn-custom text-white">Welcome, <?php echo htmlspecialchars($username); ?></span>
                    </li>
                <?php endif; ?>    
            </ul>
        </div>
    </nav>
    
