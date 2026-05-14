<?php
require_once __DIR__ . '/../../autoload.php';

use Api\Controllers\LoginController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipousuario = $_POST["tipousuario"] ?? "";
    $usuario = $_POST["usuario"] ?? "";
    $contrasenia = $_POST["contrasena"] ?? "";

    $loginController = new LoginController();
    $resultado = $loginController->login($tipousuario, $usuario, $contrasenia);

    if ($resultado["success"]) {
        session_start();
        $_SESSION["usuario"] = $resultado["usuario"];
        $_SESSION["rol"] = $resultado["rol"];
        $_SESSION["id_usuario"] = $resultado["id_usuario"];
        header("Location: ../../index.php");
        exit();
    } else {
        header("Location: ../../index.php?error=1");
        exit();
    }
}
