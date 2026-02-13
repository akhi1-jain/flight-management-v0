<?php
// api/register_passenger.php
require_once '../config/db_connect.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$data = $input ? $input : $_POST;

// 1. Validate Input
if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

$first_name = $data['first_name'];
$last_name  = $data['last_name'];
$email      = $data['email'];
$password   = $data['password'];

// 2. Check if Email Already Exists
$check = $conn->prepare("SELECT Passenger_ID FROM Passengers WHERE Email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "This email is already registered. Please login."]);
    exit;
}

// 3. Register New User
// We hash the password so it's not stored as plain text (Security Best Practice)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Passengers (First_Name, Last_Name, Email, Password) VALUES (?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Registration successful! Your Passenger ID is " . $stmt->insert_id,
            "passenger_id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed: " . $stmt->error]);
    }
}

$conn->close();
?>