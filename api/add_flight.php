<?php
// Allow PHP to read raw JSON input
$json_input = file_get_contents('php://input');
$data = json_decode($json_input, true);
if ($data) {
    $_POST = $data; // Trick PHP into thinking it's normal form data
}

// 1. Include the database connection
require_once '../config/db_connect.php';

// 2. Set header to return JSON (since we are using AJAX/Fetch)
header('Content-Type: application/json');

// 3. Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the raw POST data
    // We use 'isset' to check if the data actually exists before using it
    $flight_num = isset($_POST['flight_number']) ? $_POST['flight_number'] : '';
    $origin     = isset($_POST['origin']) ? $_POST['origin'] : '';
    $destination= isset($_POST['destination']) ? $_POST['destination'] : '';
    $dep_time   = isset($_POST['departure_time']) ? $_POST['departure_time'] : '';
    $arr_time   = isset($_POST['arrival_time']) ? $_POST['arrival_time'] : '';
    $tail_num   = isset($_POST['tail_number']) ? $_POST['tail_number'] : '';
    $price      = isset($_POST['price']) ? $_POST['price'] : '';

    // Simple validation (Check if any field is empty)
    if(empty($flight_num) || empty($origin) || empty($price)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
        exit;
    }

    // 4. Prepare the SQL Statement (The Safe Way)
    $sql = "INSERT INTO Flights (Flight_Number, Origin_Airport, Destination_Airport, Departure_Time, Arrival_Time, Tail_Number, Price) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters: 'ssssssd' means String, String, String, String, String, String, Decimal
        $stmt->bind_param("ssssssd", $flight_num, $origin, $destination, $dep_time, $arr_time, $tail_num, $price);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Flight added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing query: " . $conn->error]);
    }

} else {
    // If someone tries to open this file directly in the browser
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

// Close connection
$conn->close();
?>