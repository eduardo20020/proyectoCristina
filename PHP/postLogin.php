<?php
// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Incluimos el archivo de conexión a la base de datos
    require "conexion.php";

    // Buscamos al usuario en la base de datos
    $sql = "SELECT * FROM login WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario]);
    $resultado = $stmt->fetch();

    if ($resultado) {
        // Verificamos si la contraseña coincide con el hash almacenado
        if (password_verify($password, $resultado['passwordd'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['usuario'] = $resultado['usuario'];
            // Redireccionar al usuario a una página de bienvenida
            header("Location: bienvenida.php");
            exit;
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // El usuario no existe
        echo "El usuario no existe.";
    }

} else {
    // Si no se envió el formulario por el método POST, redireccionamos al formulario de login
    header("Location: login.php");
    exit;
}
?>
