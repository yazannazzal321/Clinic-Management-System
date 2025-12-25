<?php
$host = "host.docker.internal";
$user = "root";
$pass = "";
$dbname = "clinic_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
