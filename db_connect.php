<?php
// db_connect.php

$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto de XAMPP (suele estar vacía)
$dbname = "proyecto_login"; // El nombre de la DB que creaste

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    // Para un entorno de producción, este mensaje debe ser menos detallado.
    die("Conexión fallida: " . $conn->connect_error);
}
// echo "Conexión exitosa"; // Descomenta solo para probar
?>