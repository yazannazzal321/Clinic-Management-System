<?php
$host = getenv("DB_HOST") ?: "db";
$port = getenv("DB_PORT") ?: "3306";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "root";
$db   = getenv("DB_NAME") ?: "clinic_db";

$conn = new mysqli($host, $user, $pass, $db, (int)$port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
