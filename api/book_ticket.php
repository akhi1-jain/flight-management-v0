<?php
// api/book_ticket.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$data = $input ? $input : $_POST;

// 1. Validate Input
if (empty($data['flight_id']) || empty($data['email'])) {
    echo json_encode(["status" => "error", "message" => "Flight selection and Registered Email are required."]);
    exit;
}

$flight_id = $data['flight_id'];
$email     = $data['email'];
$seat      = !empty($data['seat']) ? $data['seat'] : 'Any';
$booking_date = date('Y-m-d H:i:s');

// 2. VERIFY USER (The "As Per Register" Logic)
$checkUser = $conn->prepare("SELECT Passenger_ID FROM Passengers WHERE Email = ?");
$checkUser->bind_param("s", $email);
$checkUser->execute();
$result = $checkUser->get_result();

if ($result->num_rows === 0) {
    // Stop! User must register first.
    echo json_encode(["status" => "error", "message" => "Email not found. Please Register first."]);
    exit;
}

$row = $result->fetch_assoc();
$passenger_id = $row['Passenger_ID'];

// 3. Create Booking
// Generate a random Booking Reference (e.g., BR-12345)
$booking_ref = "BR-" . rand(10000, 99999);

$sql = "INSERT INTO Bookings (Booking_Ref, Flight_ID, Passenger_ID, Status, Seat_Number) 
        VALUES (?, ?, ?, 'Confirmed', ?)";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("siis", $booking_ref, $flight_id, $passenger_id, $seat);
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Booking Confirmed! Ref: " . $booking_ref
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Booking failed: " . $stmt->error]);
    }
}

$conn->close();
?>