<?php

require_once "vendor/autoload.php";

use Config\Conexion;
use Controllers\ClienteController;

header('Content-Type: application/json');

try {
    $conexion = Conexion::conectar();
    $controller = new ClienteController($conexion);

    $metodo = $_SERVER['REQUEST_METHOD'];

    switch ($metodo) {

        case 'GET':
            echo json_encode($controller->listarClientes());
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->crearCliente($data));
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->actualizarCliente($data));
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->eliminarCliente($data['id']));
            break;

        default:
            echo json_encode(["error" => "Método no permitido"]);
            break;
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
