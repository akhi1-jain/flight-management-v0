<?php
// api/get_flight.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

// Added f.Arrival_Time to the SELECT list
$sql = "SELECT 
            f.Flight_ID, 
            f.Flight_Number, 
            f.Origin_Airport, 
            f.Destination_Airport, 
            f.Departure_Time, 
            f.Arrival_Time, 
            f.Price, 
            al.Airline_Name
        FROM Flights f
        JOIN Aircrafts a ON f.Tail_Number = a.Tail_Number
        JOIN Airlines al ON a.Airline_ID = al.Airline_ID
        ORDER BY f.Flight_ID DESC";

$result = $conn->query($sql);
$flights = [];
while($row = $result->fetch_assoc()) {
    $flights[] = $row;
}

echo json_encode($flights);
$conn->close();
?>