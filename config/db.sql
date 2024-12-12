
--Database: CityTaxi_db

CREATE TABLE taxi_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kmRate DECIMAL(10, 2) NOT NULL
);

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, 
    ContactNO VARCHAR(255) NOT NULL,
    user_type ENUM('P','D','O', 'A') NOT NULL
);

CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Driver INT  NOT NULL,
    vehicle_model VARCHAR(255) NOT NULL,
    vehicle_plate_no VARCHAR(100) NOT NULL,
    No_of_Seat INT NOT NULL,
    vehicle_Status VARCHAR(100) NOT NULL,
    vehicle_availability BOOLEAN  NOT NULL
);


--key="AIzaSyCrTqJOEyNjvKHmYhVxOTtlH7FcTFBYfUA" 

CREATE TABLE bookings (
    bid INT AUTO_INCREMENT PRIMARY KEY,
    passenger_id INT NOT NULL, -- References the user who made the booking
    vehicle_id INT NOT NULL, -- References the vehicle used for the booking
    pickup_location VARCHAR(255) ,
    dropoff_location VARCHAR(255) ,
    pickup_time DATETIME NULL, -- Date and time for the pickup
    dropoff_time DATETIME NULL, -- Optional drop-off time, if applicable
    distance_km DECIMAL(10, 2) NOT NULL, -- Distance of the trip in kilometers
    cost DECIMAL(10, 2) NOT NULL, -- Total cost of the booking
    status ENUM('Pending', 'Confirmed', 'Ongoing', 'Completed', 'Cancelled','Dropped') NOT NULL DEFAULT 'Pending', -- Status of the booking
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
);

SELECT bid, passenger_id, vehicle_id, pickup_location, dropoff_location, status FROM bookings;
vehicles.id=bookings.vehicle_id

bookings. passenger_id =users.id