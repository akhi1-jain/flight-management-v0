<?php
// api/login.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$data = $input ? $input : $_POST;

if (empty($data['email']) || empty($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Email and Password required."]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// 1. ADMIN CHECK (Hardcoded for simplicity)
if ($email === 'admin' && $password === 'admin') {
    echo json_encode(["status" => "success", "role" => "admin", "redirect" => "admin.html"]);
    exit;
}

// 2. PASSENGER CHECK (Database)
$stmt = $conn->prepare("SELECT Passenger_ID, Password, First_Name FROM Passengers WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // Verify Hash
    if (password_verify($password, $row['Password'])) {
        echo json_encode([
            "status" => "success", 
            "role" => "passenger", 
            "redirect" => "book_ticket.html",
            "name" => $row['First_Name']
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Password."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
}

$conn->close();
?>