<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_smartkey";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>