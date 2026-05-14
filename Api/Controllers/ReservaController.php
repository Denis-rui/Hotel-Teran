<?php

namespace Api\Controllers;

use Api\Models\ReservaDAO;

class ReservaController
{
    public function listarReservas()
    {
        $reservaDAO = new ReservaDAO();

        return $reservaDAO->obtenerReservas();
    }

    public function actualizarEstado($id_reserva, $nuevo_estado)
    {
        $reservaDAO = new ReservaDAO();
        return $reservaDAO->actualizarEstadoReserva($id_reserva, $nuevo_estado);
    }

    public function registrarReserva($reserva)
    {
        $reservaDAO = new ReservaDAO();
        return $reservaDAO->registrarReserva($reserva);
    }
}
