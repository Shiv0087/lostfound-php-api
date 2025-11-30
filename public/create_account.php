<?php
// return only JSON and suppress warnings visible to client
error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json");

require_once "db_config.php";

// Accept POST form-data or JSON body
$input = $_POST;
if (empty($input)) {
    $raw = json_decode(file_get_contents("php://input"), true);
    if (is_array($raw)) $input = $raw;
}

// Normalize keys (use same keys as Android)
$name = trim($input['name'] ?? '');
$collegeId = trim($input['collegeId'] ?? '');
$email = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');

// Validate
if ($name === '' || $collegeId === '' || $email === '' || $password === '') {
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}

// Check if email exists (use prepared statements)
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(["status"=>"error","message"=>"Email already exists"]);
    exit;
}

// Insert user (ensure columns exist in DB)
$insert = $conn->prepare("INSERT INTO users (name, college_id, email, password) VALUES (?, ?, ?, ?)");
$insert->bind_param("ssss", $name, $collegeId, $email, $password);

if ($insert->execute()) {
    echo json_encode(["status"=>"success","message"=>"Account created","uid"=>$conn->insert_id]);
} else {
    echo json_encode(["status"=>"error","message"=>"Database error"]);
}
