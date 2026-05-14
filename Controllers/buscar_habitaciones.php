<?php
require_once __DIR__ . '/../../autoload.php';

use Controllers\HabitacionController;

$controlador = new HabitacionController();

$numero_habitacion = $_GET['numero_habitacion'] ?? '';
$id_tipo_habitacion = $_GET['id_tipo_habitacion'] ?? '';
$estado = $_GET['estado'] ?? '';

$habitaciones = $controlador->buscar($numero_habitacion, $id_tipo_habitacion, $estado);

if (!empty($habitaciones) && is_array($habitaciones)):
    foreach ($habitaciones as $hab): ?>
        <div class="tarjeta-habitacion <?= strtolower(htmlspecialchars($hab['estado'])) ?>">
            <div class="habitacion-numero"><?= str_pad(htmlspecialchars($hab["numero_habitacion"]), 2, "0", STR_PAD_LEFT); ?></div>
            <div class="habitacion-tipo"><?= htmlspecialchars($hab['tipo_nombre']); ?></div>
            <div class="habitacion-precio">S/ <?= htmlspecialchars($hab['precio']); ?> <span>/ Dia</span></div>
            <div class="habitacion-descripcion"><?= htmlspecialchars($hab['descripcion'] ?? 'Sin descripción'); ?></div>
            <div class="habitacion-acciones">
                <div class="habitacion-estado"><?= htmlspecialchars($hab['estado']); ?></div>
                <select class="selector-estado" onchange="cambiarEstado(<?= $hab['id'] ?>, this.value)">
                    <option value="" disabled selected>Cambiar</option>
                    <option value="Disponible">Disponible</option>
                    <option value="Ocupada">Ocupada</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Reservada">Reservada</option>
                </select>
            </div>
        </div>
    <?php endforeach;
else: ?>
    <p>No hay habitaciones para mostrar.</p>
<?php endif; ?>