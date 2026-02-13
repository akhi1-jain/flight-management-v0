<?php
// api/get_form_options.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

// 1. Fetch Airports
$airports = [];
$sql_airports = "SELECT Airport_Code, City FROM Airports";
$result = $conn->query($sql_airports);
while($row = $result->fetch_assoc()) {
    $airports[] = $row;
}

// 2. Fetch Aircrafts
$aircrafts = [];
$sql_aircrafts = "SELECT Tail_Number, Model FROM Aircrafts";
$result2 = $conn->query($sql_aircrafts);
while($row = $result2->fetch_assoc()) {
    $aircrafts[] = $row;
}

// 3. NEW: Fetch Airlines (for IATA Code selection)
$airlines = [];
$sql_airlines = "SELECT Airline_Name, IATA_Code FROM Airlines";
$result3 = $conn->query($sql_airlines);
while($row = $result3->fetch_assoc()) {
    $airlines[] = $row;
}

// 4. Send everything back as one JSON object
echo json_encode([
    "airports" => $airports,
    "aircrafts" => $aircrafts,
    "airlines" => $airlines
]);

$conn->close();
?>