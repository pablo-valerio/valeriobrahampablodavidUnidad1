<?php
// registro.php (Parte PHP)

// Incluye el archivo de conexión
include 'db_connect.php';

// Comprueba si se ha enviado el formulario de registro
if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // 🔑 USANDO HASH DE CONTRASEÑA (¡ESENCIAL por seguridad!)
    // Nunca guardes contraseñas sin cifrar.
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";

    // Prepara la declaración para evitar inyección SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hashed_password);

    if ($stmt->execute()) {
        $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
        // Opcionalmente, redirige a la página de inicio de sesión
        // header("Location: index.php?registro=exito");
    } else {
        // En caso de error (ej: email duplicado)
        $mensaje = "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
}
// El mensaje de éxito o error ($mensaje) se puede mostrar en la parte HTML.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style/registro.css">
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit" name="registrar">Registrar</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="index.php">Inicia Sesión aquí</a></p>
    </div>
</body>
</html>