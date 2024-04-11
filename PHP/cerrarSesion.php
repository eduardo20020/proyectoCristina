<?php
session_start(); // Iniciar la sesión si no está iniciada

// Destruir todas las variables de sesión
$_SESSION = array();

// Borrar la cookie de la sesión si está presente
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destruir la sesión
session_destroy();

// Redireccionar a la página de inicio de sesión o a cualquier otra página deseada
header("Location: ../index.php");
exit();
?>