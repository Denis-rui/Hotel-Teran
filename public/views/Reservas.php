<?php
require_once __DIR__ . '/../../autoload.php';

use Api\Controllers\ReservaController;

$controladorReserva = new ReservaController();
$reservas = $controladorReserva->listarReservas();


?>


<section class="reservas">
  <header class="header-reservas">
    <h2 class="titulo-reservas">Reservas</h2>
    <button id="btnNuevaReserva" type="button" class="boton-nueva-reserva">
      Nueva Reserva
    </button>
  </header>

  <div class="buscar-filtro">
    <input
      class="buscar"
      id="inputBuscarReserva"
      type="text"
      placeholder="🔍 Buscar " />
    <select id="filtroEstado" class="filtro-estado">
      <option value="">Todos los estados</option>
      <option value="Confirmada">Confirmado</option>
      <option value="Pendiente">Pendiente</option>
      <option value="Cancelada">Cancelado</option>
    </select>
  </div>

  <div class="tabla">
    <table class="tbl-reservas">
      <thead>
        <tr>
          <th>Cliente</th>
          <th>Habitación</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Pago</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenido-reservas">
        <?php foreach ($reservas as $reserva) : ?>
          <tr data-id="<?= $reserva["id"] ?>" data-estado="<?= $reserva["estado"] ?>" data-porcentajepago="<?= $reserva["porcentaje_pago"] ?>" data-total="<?= $reserva["total"] ?>" data-cliente="<?= $reserva["cliente"] ?>" data-habitacion="<?= $reserva["habitacion"] ?>" data-checkin="<?= $reserva["check_in"] ?>" data-checkout="<?= $reserva["check_out"] ?>" data-email="<?= $reserva["correo_electronico"] ?>">
            <td><?= $reserva["cliente"] ?></td>
            <td><?= $reserva["habitacion"] ?></td>
            <td><?= $reserva["check_in"] ?></td>
            <td><?= $reserva["check_out"] ?></td>
            <td><?= $reserva["total"] ?></td>
            <td><?= $reserva["estado"] ?></td>
            <td>
              <div class="celda-pago">
                <span class="porcentaje-pago"><?= $reserva["porcentaje_pago"] ?>%</span>
                <?php if ($reserva["porcentaje_pago"] < 100) : ?>
                  <button class="boton-pago-tabla" data-id="<?= $reserva["id"] ?>" title="Registrar pago">
                    💳
                  </button>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <button class="boton-editar-reserva" data-id="<?= $reserva["id"] ?>">
                ✏️
              </button>
              <button class="boton-eliminar-reserva" data-id="<?= $reserva["id"] ?>">
                ❌
              </button>
            </td>
          </tr>
        <?php endforeach; ?>


      </tbody>
    </table>
  </div>
</section>