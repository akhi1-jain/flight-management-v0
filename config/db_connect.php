<?php
// Database configuration
$host = "localhost";
$username = "root";       // Default XAMPP username
$password = "";           // Default XAMPP password is empty
$dbname = "FlightManagementDB";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, stop the script and send a JSON error
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Optional: Set charset to handle special characters
$conn->set_charset("utf8");
?>