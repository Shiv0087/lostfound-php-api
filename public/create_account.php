<?php
// ----------------------------------------------------
// DISABLE ALL WARNINGS + FORCE JSON OUTPUT
// ----------------------------------------------------
error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json");

require "db_config.php";

// SAFE INPUT HANDLING
$name = $_POST["name"] ?? "";
$collegeId = $_POST["collegeId"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

// VALIDATION
if (!$name || !$collegeId || !$email || !$password) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

// CHECK EMAIL EXISTING
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit;
}

// INSERT NEW USER
$stmt = $conn->prepare("INSERT INTO users (name, college_id, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $collegeId, $email, $password);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "uid" => $conn->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database insert failed"
    ]);
}
?>
