<?php
// Cargamos automáticamente las clases del proyecto.
require_once __DIR__ . '/../Libraries/Core/Autoload.php';

use Controllers\LoginController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipousuario = $_POST["tipousuario"] ?? "";
    $usuario = $_POST["usuario"] ?? "";
    $contrasenia = $_POST["contrasena"] ?? "";

    $loginController = new LoginController();
    $resultado = $loginController->login($tipousuario, $usuario, $contrasenia);

    if ($resultado["success"]) {
        // Guardamos los datos mínimos de sesión para saber que el usuario ya inició sesión.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["usuario"] = $resultado["usuario"];
        $_SESSION["rol"] = $resultado["rol"];
        $_SESSION["id_usuario"] = $resultado["id_usuario"];
        header("Location: ../index.php");
        exit();
    } else {
        // Si falla, regresamos al formulario con un aviso sencillo.
        header("Location: ../index.php?error=1");
        exit();
    }
}
