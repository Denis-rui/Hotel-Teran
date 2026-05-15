<?php
// Cargamos automaticamente las clases (Controladores, Modelos, etc.).
require_once __DIR__ . '/../LIbraries/Core/autoload.php';

use Controllers\LoginController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturamos campos del formulario y dejamos valores por defecto seguros.
    $tipousuario = $_POST["tipousuario"] ?? "";
    $usuario = $_POST["usuario"] ?? "";
    $contrasenia = $_POST["contrasena"] ?? "";

    // El controlador concentra la validacion de credenciales.
    $loginController = new LoginController();
    $resultado = $loginController->login($tipousuario, $usuario, $contrasenia);

    if ($resultado["success"]) {
        // Guardamos los datos minimos de sesion para identificar al usuario logueado.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["usuario"] = $resultado["usuario"];
        // nombreUsuario se usa en otros modulos, lo mantenemos para compatibilidad.
        $_SESSION["nombreUsuario"] = $resultado["usuario"];
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
