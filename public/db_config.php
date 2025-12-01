<?php
$host = "johnny.heliohost.org";   // remote host
$username = "lostandfound_user";  // your DB username
$password = "j64@bp4h?VbYGsec";   // your DB password
$database = "lostandfound_db";    // your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "DB Connection failed: " . $conn->connect_error
    ]));
}
?>
