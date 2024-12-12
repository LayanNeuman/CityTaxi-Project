<?php

// Database connection settings
$host = 'localhost'; // Your database host
$db = 'CityTaxi_db'; // Your database name
$user = 'root'; // Your database user
$pass = ''; // Your database password

// Establish a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo 'sucess';
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}


?>