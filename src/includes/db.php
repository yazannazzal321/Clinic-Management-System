<?php
$host = "db";        // IMPORTANT (service name in docker-compose)
$user = "root";
$pass = "root";      // MUST match MYSQL_ROOT_PASSWORD in docker-compose.yml
$db   = "clinic_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
