<?php
require_once __DIR__ . '/../../autoload.php';

use Api\Config\Conexion;
use Api\Models\ClienteDAO;

header('Content-Type: application/json; charset=utf-8');

// 1) Leer texto de busqueda
$texto = trim($_GET['q'] ?? '');

try {
    // 2) Consultar clientes
    $conexion = Conexion::conectar();
    $clienteController = new ClienteDAO($conexion);
    $clientes = $clienteController->buscarClientesParaReserva($texto);

    // 3) Responder en JSON
    if (isset($clientes['error'])) {
        echo json_encode(['clientes' => []], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['clientes' => $clientes], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(['clientes' => []], JSON_UNESCAPED_UNICODE);
}
