<?php
header('Content-Type: application/json');
require 'db_config.php';

// Check if uid and phone are set in the POST request
if (!isset($_POST['uid']) || !isset($_POST['phone'])) {
    echo json_encode(["status" => "error", "message" => "User ID and phone number are required."]);
    exit();
}

$uid = $_POST['uid'];
$phone = $_POST['phone'];

if (empty($uid)) {
    echo json_encode(["status" => "error", "message" => "User ID cannot be empty."]);
    exit();
}

// Prepare the UPDATE statement
$stmt = $conn->prepare("UPDATE users SET phone = ? WHERE uid = ?");
$stmt->bind_param("ss", $phone, $uid);

// Execute the statement and check for success
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Phone number updated successfully."]);
    } else {
        // This can happen if the user doesn't exist or the phone number was already the same
        echo json_encode(["status" => "error", "message" => "User not found or phone number unchanged."]);
    }
} else {
    // This happens if there is a database error
    echo json_encode(["status" => "error", "message" => "Error updating phone number: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>