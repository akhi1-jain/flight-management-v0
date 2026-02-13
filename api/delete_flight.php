<?php
// api/delete_flight.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

// Get raw POST data (works for JSON and Form Data)
$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['flight_id']) ? $input['flight_id'] : '';

if (empty($id)) {
    echo json_encode(["status" => "error", "message" => "Flight ID is required"]);
    exit;
}

// Prepare Delete Statement
// Remember: Because of ON DELETE CASCADE in your DB, 
// this will automatically delete all Bookings for this flight too!
$stmt = $conn->prepare("DELETE FROM Flights WHERE Flight_ID = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Flight deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error deleting flight"]);
}

$stmt->close();
$conn->close();
?>