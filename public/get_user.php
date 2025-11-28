<?php
header('Content-Type: application/json');
require 'db_config.php';

// Check if uid is provided in the URL, e.g., get_user.php?uid=some_id
if (!isset($_GET['uid'])) {
    echo json_encode(["status" => "error", "message" => "User ID is required."]);
    exit();
}

$uid = $_GET['uid'];

if (empty($uid)) {
    echo json_encode(["status" => "error", "message" => "User ID cannot be empty."]);
    exit();
}

$stmt = $conn->prepare("SELECT uid, name, collegeId, email, phone FROM users WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // User was found, return their data
    echo json_encode(["status" => "success", "user" => $user]);
} else {
    // No user found for the given uid
    echo json_encode(["status" => "error", "message" => "User not found."]);
}

$stmt->close();
$conn->close();
?>
