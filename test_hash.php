<?php
$password = 'm1Clave'; // Contraseña que vamos a usar
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "Contraseña Original: " . $password . "<br>";
echo "Hash Generado: " . $hashed_password . "<br><br>";

// Prueba 1: Verificar el hash que acabamos de generar
if (password_verify($password, $hashed_password)) {
    echo "VERIFICACIÓN 1: ¡El hash funciona inmediatamente! (PASS)<br>";
} else {
    echo "VERIFICACIÓN 1: ¡El hash FALLA inmediatamente! (FAIL)<br>";
}

// Para debugging:
echo "<hr>Prueba el login con: Email: test@email.com, Contraseña: m1Clave. Si falla, el problema es el hash guardado.<br>";
?>