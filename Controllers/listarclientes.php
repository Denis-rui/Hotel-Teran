<?php

require_once __DIR__ . '/../../autoload.php';

use Config\Conexion;

header("Content-Type: application/json");

try {
    $conexion = Conexion::conectar();

    $sql = "SELECT c.id,
                   c.nombre_completo AS nombre,
                   COALESCE(CONCAT(d.tipo_documento, ': ', d.numero_documento), '') AS documento,
                   c.correo_electronico AS gmail,
                   c.telefono,
                   c.procedencia AS nacionalidad
            FROM cliente c
            LEFT JOIN documento_identidad d ON d.id_cliente = c.id
            ORDER BY c.id DESC";

    $stmt = $conexion->query($sql);
    $clientes = $stmt->fetchAll();

    echo json_encode($clientes);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
