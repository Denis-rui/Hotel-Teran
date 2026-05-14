<?php

require_once __DIR__ . '/../../autoload.php';

use Config\Conexion;
use Controllers\ClienteController;

$conexion = Conexion::conectar();
$controller = new ClienteController($conexion);

header('Content-Type: application/json');

// listar
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($controller->listarClientes());
}

// crear
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($controller->crearCliente($data));
}

// eliminar
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    echo json_encode($controller->eliminarCliente($data['id']));
}
