<?php
// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["Cpassword"];

    // Validamos que las contraseñas coincidan
    if ($password !== $confirmPassword) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Incluimos el archivo de conexión a la base de datos
    require "conexion.php";

    // Verificamos si el usuario ya existe en la base de datos
    $sql = "SELECT * FROM login WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario]);
    $resultado = $stmt->fetch();

    if ($resultado) {
        echo "El usuario ya existe.";
        exit;
    }

    // Insertamos el nuevo usuario en la base de datos
    $sql = "INSERT INTO login (usuario, passwordd) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hasheamos la contraseña
    $stmt->execute([$usuario, $hashedPassword]);
    if ($stmt->rowCount() > 0) {
        echo "Registro exitoso.";
    } else {
        echo "Error al registrar el usuario.";
    }

} else {
    // Si no se envió el formulario por el método POST, redireccionamos al formulario de registro
    header("Location: registro.php");
    exit;
}
?>
