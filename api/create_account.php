<?php
require 'db_config.php';

$name = $_POST['name'];
$collegeId = $_POST['collegeId'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($name) || empty($collegeId) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$uid = uniqid('user_');

$stmt = $conn->prepare("INSERT INTO users (uid, name, collegeId, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $uid, $name, $collegeId, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "uid" => $uid]);
} else {
    echo json_encode(["status" => "error", "message" => "Error creating account"]);
}

$stmt->close();
$conn->close();
?>