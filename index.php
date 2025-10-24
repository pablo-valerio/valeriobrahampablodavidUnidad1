<?php
// index.php (Parte PHP - Login)

session_start();
include 'db_connect.php'; 

// Comprueba si el usuario ya está logueado
if (isset($_SESSION['user_id'])) {
    header("Location: bienvenido.php");
    exit;
}

$error = null; 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // 1. Buscar el usuario por email
    $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $error = "Error interno de la base de datos."; 
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) { 
            $user = $result->fetch_assoc();
            $hashed_password = $user['contrasena'];

            // 2. Verificar la contraseña con el hash
            if (password_verify($contrasena, $hashed_password)) {
                
                // 🔐 CASO 1: CONTRASEÑA CORRECTA
                echo '<script>alert("✅ ¡Éxito! La contraseña es correcta.");</script>';
                
                // 3. Inicio de sesión exitoso: Guarda datos en la sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];

                header("Location: bienvenido.php");
                exit; 
                
            } else {
                // ❌ CASO 2: CONTRASEÑA INCORRECTA
                $error = "Contraseña incorrecta."; 
            }
        } else {
            $error = "No existe un usuario con ese email.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style/index.css"> 
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        
        <?php 
        // Solo inyecta el elemento si el error es de contraseña incorrecta
        if ($error === "Contraseña incorrecta.") {
            echo '<div id="login-error" data-error-type="password_incorrect" style="display: none;"></div>';
        } 
        
        // Mostrar otros errores de forma visible
        if (isset($error) && $error !== "Contraseña incorrecta.") {
            echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
        }
        ?>
        
        <form action="index.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit" name="login">Entrar</button>
        </form>
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorElement = document.getElementById('login-error');

        if (errorElement && errorElement.getAttribute('data-error-type') === 'password_incorrect') {
            
            // Muestra la alerta de JavaScript para CONTRASEÑA INCORRECTA
            alert("❌ ¡Fallo! La contraseña ingresada es incorrecta.");
            
            const passwordField = document.getElementById('contrasena');
            if (passwordField) {
                passwordField.value = '';
            }
        }
    });
    </script>
</body>
</html>