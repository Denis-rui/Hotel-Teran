<?php
require_once __DIR__ . '/../../autoload.php';

use Controllers\HabitacionController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    header('Content-Type: application/json');
    $controller = new HabitacionController();

    if ($_POST['accion'] === 'guardar') {
        $numero = $_POST['numero'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $estado = $_POST['estado'] ?? 'Disponible';
        $descripcion = $_POST['descripcion'] ?? '';

        $exito = $controller->registrar($numero, $tipo, $precio, $estado, $descripcion);

        echo json_encode([
            'exito' => !!$exito,
            'mensaje' => $exito ? '¡Habitación guardada con éxito! ✨' : 'Error al guardar la habitación en la base de datos.'
        ]);
        exit();
    }

    if ($_POST['accion'] === 'cambiar_estado') {
        $id = $_POST['id'] ?? 0;
        $nuevoEstado = $_POST['estado'] ?? '';

        if ($id > 0 && !empty($nuevoEstado)) {
            $exito = $controller->actualizarEstado($id, $nuevoEstado);
            echo json_encode([
                'exito' => !!$exito,
                'mensaje' => $exito ? '¡Estado actualizado correctamente! ✅' : 'Error al actualizar el estado.'
            ]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Datos insuficientes.']);
        }
        exit();
    }
}
