<?php

namespace Controllers;

use Models\HabitacionDAO;
use Models\Habitacion;


class HabitacionController
{

    public function registrar($numero_habitacion, $id_tipo_habitacion, $precio, $estado, $descripcion = '')
    {

        $habitacionDao = new HabitacionDAO();

        $objH = new Habitacion(
            $numero_habitacion,
            $id_tipo_habitacion,
            $precio,
            $estado,
            $descripcion
        );

        return $habitacionDao->insert($objH);
    }

    public function buscar($numero, $tipo, $estado)
    {

        $habitacionDao = new HabitacionDAO();

        $objH = new Habitacion(null, null, null, null);

        $objH->set('numero_habitacion', $numero);
        $objH->set('id_tipo_habitacion', $tipo);
        $objH->set('estado', $estado);

        return $habitacionDao->readFiltro($objH);
    }

    public function listarHabitaciones()
    {
        // Devuelve todas las habitaciones sin filtros
        return $this->buscar('', '', '');
    }

    public function actualizarEstado($id, $estado)
    {
        $habitacionDao = new HabitacionDAO();
        return $habitacionDao->updateEstado($id, $estado);
    }

    public function obtenerFiltros()
    {
        $habitacionDao = new HabitacionDAO();
        return $habitacionDao->obtenerFiltros();
    }
    public function habitacionesDispnibles()
    {
        $habitacionDao = new HabitacionDAO();
        return $habitacionDao->habitacionesDisponibles();
    }
}
