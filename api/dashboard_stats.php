<?php
// api/dashboard_stats.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

// Helper function to get count
function getCount($conn, $table) {
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    return $row['total'];
}

$response = [
    "flights"    => getCount($conn, "Flights"),
    "bookings"   => getCount($conn, "Bookings"),
    "passengers" => getCount($conn, "Passengers"),
    "airlines"   => getCount($conn, "Airlines")
];

echo json_encode($response);
$conn->close();
?>