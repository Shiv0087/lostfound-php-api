<?php
header('Content-Type: application/json');
require 'db_config.php';

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;

if ($userId) {
    // If a userId is provided, fetch items for that specific user
    $stmt = $conn->prepare("SELECT * FROM items WHERE userId = ? ORDER BY id DESC");
    $stmt->bind_param("s", $userId);
} else {
    // If no userId is provided, fetch all items
    $stmt = $conn->prepare("SELECT * FROM items ORDER BY id DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$items = array();

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(["status" => "success", "items" => $items]);

$stmt->close();
$conn->close();
?>