<?php
// api/update_flight.php

// 1. Include Database Connection
require_once '../config/db_connect.php';

// 2. Set headers to handle JSON input (from Fetch/Postman)
header('Content-Type: application/json');

// 3. Get the Input Data
// We check both $_POST (Form Data) and raw JSON (Postman/Fetch)
$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    // If input is JSON, use it
    $data = $input;
} else {
    // If input is Form Data, use $_POST
    $data = $_POST;
}

// 4. Validate Input
if (!isset($data['flight_id']) || empty($data['flight_id'])) {
    echo json_encode(["status" => "error", "message" => "Flight ID is required for updates."]);
    exit;
}

// Assign variables (Use ternary operator to keep existing value if not provided - optional, but safer to require all)
$id          = $data['flight_id'];
$flight_num  = $data['flight_number'];
$origin      = $data['origin'];
$destination = $data['destination'];
$dep_time    = $data['departure_time'];
$arr_time    = $data['arrival_time'];
$tail_num    = $data['tail_number'];
$price       = $data['price'];

// 5. Prepare SQL Update Statement
$sql = "UPDATE Flights SET 
        Flight_Number = ?, 
        Origin_Airport = ?, 
        Destination_Airport = ?, 
        Departure_Time = ?, 
        Arrival_Time = ?, 
        Tail_Number = ?, 
        Price = ? 
        WHERE Flight_ID = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters: 'ssssssdi' -> 6 Strings, 1 Decimal, 1 Integer (ID)
    $stmt->bind_param("ssssssdi", $flight_num, $origin, $destination, $dep_time, $arr_time, $tail_num, $price, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Flight updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating flight: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}

$conn->close();
?>