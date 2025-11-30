<?php
$host = "johnny.heliohost.org";  //
$username = "lostandfound_user";
$password = "j64@bp4h?VbYGsec";
$database = "lostandfound_db";

$conn = new mysqli($host, $username, $password, $database, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
