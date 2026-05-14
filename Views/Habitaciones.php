<?php
require_once __DIR__ . '/../../autoload.php';

use Controllers\HabitacionController;

$controlador = new HabitacionController();

$filtros = $controlador->obtenerFiltros();

// Leer filtros
$numero_habitacion = $_GET['numero_habitacion'] ?? '';
$id_tipo_habitacion  = $_GET['id_tipo_habitacion'] ?? '';
$estado = $_GET['estado'] ?? '';

// Buscar
$habitaciones = $controlador->buscar($numero_habitacion, $id_tipo_habitacion, $estado);
?>

<section class="contenedor-habitaciones">

  <div class="cabecera-habitaciones">
    <h1>Habitaciones</h1>
    <div class="cabecera-derecha">
      <button class="btn-nueva-habitacion" id="btnNuevaHabitacion">
        + Nueva Habitación
      </button>
    </div>
  </div>


  <form method="GET" class="seccion-filtros">

    <div class="caja-busqueda">
      <span>🔍</span>
      <input
        type="text"
        id="inputBuscar"
        name="numero_habitacion"
        placeholder="Buscar habitación..."
        value="<?= $numero_habitacion ?>" />
    </div>

    <!-- TIPOS -->
    <select name="id_tipo_habitacion">
      <option value="">Todos los tipos</option>

      <?php if (!empty($filtros['tipos'])): ?>
        <?php foreach ($filtros['tipos'] as $tipo): ?>
          <option
            value="<?= $tipo['id'] ?>"
            <?= ($id_tipo_habitacion == $tipo['id']) ? 'selected' : '' ?>>
            <?= $tipo['tipo'] ?>
          </option>
        <?php endforeach; ?>
      <?php endif; ?>

    </select>

    <!-- ESTADOS -->
    <select name="estado">
      <option value="">Todos los estados</option>

      <?php if (!empty($filtros['estados'])): ?>
        <?php foreach ($filtros['estados'] as $estadoItem): ?>
          <option
            value="<?= $estadoItem ?>"
            <?= ($estado == $estadoItem) ? 'selected' : '' ?>>
            <?= $estadoItem ?>
          </option>
        <?php endforeach; ?>
      <?php endif; ?>

    </select>


  </form>

  <div class="grid-habitaciones">
    <?php if (!empty($habitaciones) && is_array($habitaciones)): ?>
      <?php foreach ($habitaciones as $hab): ?>

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

      <?php endforeach; ?>
    <?php else: ?>
      <p>No hay habitaciones para mostrar.</p>
    <?php endif; ?>
  </div>

</section>