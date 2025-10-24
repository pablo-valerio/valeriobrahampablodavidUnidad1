<?php
// logout.php

session_start();

// Destruye todas las variables de sesión
$_SESSION = array();

// Si se usa `session_id()`, también se debe borrar la cookie de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión.
session_destroy();

// Redirige al inicio de sesión
header("Location: index.php");
exit;
?>