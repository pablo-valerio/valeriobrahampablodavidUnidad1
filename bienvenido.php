<?php
// bienvenido.php

// Siempre inicia la sesión para acceder a las variables de usuario
session_start();

// Verifica si el usuario NO está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Si está logueado, obtenemos su nombre para personalizar el saludo
$nombre_usuario = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a SABERH</title>
    <link rel="stylesheet" href="style/bienvenido.css">
</head>
<body>
    <div class="container">
        <h1>¡Hola, <?php echo htmlspecialchars($nombre_usuario); ?>!</h1>
        <p class="saludo-secundario">Bienvenido a tu panel de usuario en SABERH.</p>
        
        <div class="card">
            <h3>Información de tu Sesión</h3>
            <p><strong>Estado:</strong> Sesión Activa (HTTPS)</p>
            <p><strong>ID de Usuario:</strong> <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
            <p>Este es el área principal donde iría el contenido privado de la aplicación (links, datos, etc.).</p>
        </div>
        
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</body>
</html>