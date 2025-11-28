<?php
header('Content-Type: application/json');
require 'db_config.php';

// Check for required fields
if (!isset($_POST['name']) || !isset($_POST['status']) || !isset($_POST['userId'])) {
    echo json_encode(["status" => "error", "message" => "Name, status, and userId are required."]);
    exit();
}

$name = $_POST['name'];
$status = $_POST['status'];
$userId = $_POST['userId'];

// Optional fields
$description = isset($_POST['description']) ? $_POST['description'] : null;
$location = isset($_POST['location']) ? $_POST['location'] : null;
$imageUri = isset($_POST['imageUri']) ? $_POST['imageUri'] : null;


$stmt = $conn->prepare("INSERT INTO items (name, description, location, status, imageUri, userId) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $description, $location, $status, $imageUri, $userId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Item added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add item: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>