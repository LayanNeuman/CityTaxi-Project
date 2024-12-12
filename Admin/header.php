<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./admin.css">
</head>

<body>
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">CItyTaxi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav side-nav" >
              <li class="nav-item">
                <a class="nav-link" style="margin-left: 20px;" href="index.php">Dashboard
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Booking.php" style="margin-left: 20px;">Booking</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Bookingmanage.php"style="margin-left: 20px;">Booking Manage</a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="TaxiAva.php" style="margin-left: 20px;">Taxi Avilabity</a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="kmrate.php" style="margin-left: 20px;">KM Rate</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user.php" style="margin-left: 20px;">User</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user.php" style="margin-left: 20px;">Report</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-md-auto d-md-flex">
              <li class="nav-item dropdown">
                <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  username
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="logOut.php">Logout</a>
                  
              </li>           
            </ul>
        </div>
      </div>
    </nav>