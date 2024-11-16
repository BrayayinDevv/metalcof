<?php
$host = 'localhost';
$db = 'metalcof';
$user = 'root';
$password = '';

$conn = new mysqli(hostname: $host, username: $user, password: $password, database: $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>