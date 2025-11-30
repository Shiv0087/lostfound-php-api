<?php
error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json");

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

// Accept both form-data & raw JSON
$input = $_POST;

if (empty($input)) {
    $raw = json_decode(file_get_contents("php://input"), true);
    if (!empty($raw)) {
        $input = $raw;
    }
}

$name = $input["name"] ?? "";
$collegeId = $input["collegeId"] ?? "";
$email = $input["email"] ?? "";
$password = $input["password"] ?? "";

// Validate
if (empty($name) || empty($collegeId) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

require_once "db_config.php";

// Check existing user
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists"]);
    exit();
}

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, collegeId, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $collegeId, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Account created", "uid" => $conn->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}
?>
