<?php

require_once __DIR__ . '/../../autoload.php';

use Api\Config\Conexion;

header("Content-Type: application/json");

try {
    $conexion = Conexion::conectar();
    $conexion->beginTransaction();

    $nombre = $_POST['nombre'];
    $documento = trim($_POST['dni'] ?? '');
    $gmail = $_POST['gmail'];
    $telefono = $_POST['telefono'];
    $nacionalidad = $_POST['nacionalidad'];

    $sql = "INSERT INTO cliente 
        (nombre_completo, correo_electronico, telefono, procedencia)
        VALUES 
        (:nombre, :gmail, :telefono, :nacionalidad)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ":nombre" => $nombre,
        ":gmail" => $gmail,
        ":telefono" => $telefono,
        ":nacionalidad" => $nacionalidad
    ]);

    $idCliente = (int)$conexion->lastInsertId();
    if ($idCliente <= 0) {
        throw new Exception("No se pudo obtener el ID del cliente creado");
    }

    $soloDigitos = preg_replace('/\D+/', '', $documento);
    $tipoDocumento = strlen($soloDigitos) === 8 ? 'DNI' : 'PASAPORTE';

    $sqlDoc = "INSERT INTO documento_identidad (tipo_documento, numero_documento, id_cliente)
               VALUES (:tipo_documento, :numero_documento, :id_cliente)";

    $stmtDoc = $conexion->prepare($sqlDoc);
    $stmtDoc->execute([
        ':tipo_documento' => $tipoDocumento,
        ':numero_documento' => $documento,
        ':id_cliente' => $idCliente
    ]);

    $conexion->commit();

    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    if (isset($conexion) && $conexion->inTransaction()) {
        $conexion->rollBack();
    }

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
