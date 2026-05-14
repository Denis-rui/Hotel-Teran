<?php
session_start();
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./public/assets/img/image.jpeg" />
    <title>Hotel Teran</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="./public/css/Login.css" />
    <link rel="stylesheet" href="./public/css/Nav.css" />
    <link rel="stylesheet" href="./public/css/Usuarios.css" />
    <link rel="stylesheet" href="./public/css/Modal-Usuarios.css" />
    <link rel="stylesheet" href="./public/css/Configuraciones.css" />
    <link rel="stylesheet" href="./public/css/Dashboard.css" />
    <link rel="stylesheet" href="./public/css/Modal-Dashboard.css" />
    <link rel="stylesheet" href="./public/css/Reservas.css" />
    <link rel="stylesheet" href="./public/css/Perfil.css" />
    <link rel="stylesheet" href="./public/css/Habitaciones.css" />
    <link rel="stylesheet" href="./public/css/Modal-Habitaciones.css" />
    <link rel="stylesheet" href="./public/css/Clientes.css" />
    <link rel="stylesheet" href="./public/css/Modal-Clientes.css" />
    <link rel="stylesheet" href="./public/css/Pago.css" />
    <link rel="stylesheet" href="./public/css/Notificaciones.css" />
</head>

<body>
    <?php if (isset($_SESSION["usuario"])): ?>
        <div id="nav">
            <?php include("./public/views/Nav.php"); ?>
        </div>

        <div id="app"></div>

        <div id="contenedorModal"></div>

    <?php else: ?>

        <div id="app">
            <?php include("./public/views/Login.php"); ?>
        </div>

    <?php endif; ?>

    <script src="./main.js"></script>
    <script src="./public/js/Login.js"></script>
    <script src="./public/js/Nav.js"></script>
    <script src="./public/js/Usuarios.js"></script>
    <script src="./public/js/Modal-Usuario.js"></script>
    <script src="./public/js/Configuraciones.js"></script>
    <script src="./public/js/Modal-Dashboard.js"></script>
    <script src="./public/js/Reservas.js"></script>
    <script src="./public/js/Habitaciones.js"></script>
    <script src="./public/js/Modal-Habitaciones.js"></script>
    <script src="./public/js/Clientes.js"></script>
    <script src="./public/js/Modal-Clientes.js"></script>
    <script src="./public/js/Pago.js"></script>
    <script src="./public/js/Notificaiones.js"></script>
</body>

</html>