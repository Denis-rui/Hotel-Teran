<?php
session_start();
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./Assets/img/image.jpeg" />
    <title>Hotel Teran</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="./Assets/css/Login.css" />
    <link rel="stylesheet" href="./Assets/css/Nav.css" />
    <link rel="stylesheet" href="./Assets/css/Usuarios.css" />
    <link rel="stylesheet" href="./Assets/css/Modal-Usuarios.css" />
    <link rel="stylesheet" href="./Assets/css/Configuraciones.css" />
    <link rel="stylesheet" href="./Assets/css/Dashboard.css" />
    <link rel="stylesheet" href="./Assets/css/Modal-Dashboard.css" />
    <link rel="stylesheet" href="./Assets/css/Reservas.css" />
    <link rel="stylesheet" href="./Assets/css/Perfil.css" />
    <link rel="stylesheet" href="./Assets/css/Habitaciones.css" />
    <link rel="stylesheet" href="./Assets/css/Modal-Habitaciones.css" />
    <link rel="stylesheet" href="./Assets/css/Clientes.css" />
    <link rel="stylesheet" href="./Assets/css/Modal-Clientes.css" />
    <link rel="stylesheet" href="./Assets/css/Pago.css" />
    <link rel="stylesheet" href="./Assets/css/Notificaciones.css" />
</head>

<body>
    <?php if (isset($_SESSION["usuario"])): ?>
        <!-- Cuando ya hay sesión activa, se muestra la navegación y el contenedor de la app -->
        <div id="nav">
            <?php include("./views/Nav.php"); ?>
        </div>

        <div id="app"></div>

        <div id="contenedorModal"></div>

    <?php else: ?>

        <!-- Si no hay sesión, se carga solo el formulario de acceso -->
        <div id="app">
            <?php include("./views/Login.php"); ?>
        </div>

    <?php endif; ?>

    <script src="./main.js"></script>
    <script src="./Assets/js/Login.js"></script>
    <script src="./Assets/js/Nav.js"></script>
    <script src="./Assets/js/Usuarios.js"></script>
    <script src="./Assets/js/Modal-Usuario.js"></script>
    <script src="./Assets/js/Configuraciones.js"></script>
    <script src="./Assets/js/Modal-Dashboard.js"></script>
    <script src="./Assets/js/Reservas.js"></script>
    <script src="./Assets/js/Habitaciones.js"></script>
    <script src="./Assets/js/Modal-Habitaciones.js"></script>
    <script src="./Assets/js/Clientes.js"></script>
    <script src="./Assets/js/Modal-Clientes.js"></script>
    <script src="./Assets/js/Pago.js"></script>
    <script src="./Assets/js/Notificaiones.js"></script>
</body>

</html>