<?php

namespace Api\Models;

class Habitacion
{
    public $id;
    public $numero_habitacion;
    public $id_tipo_habitacion;
    public $precio;
    public $estado;
    public $descripcion;

    public function __construct($numero_habitacion, $id_tipo_habitacion, $precio, $estado, $descripcion = '', $id = null)
    {
        $this->id = $id;
        $this->numero_habitacion = $numero_habitacion;
        $this->id_tipo_habitacion = $id_tipo_habitacion;
        $this->precio = $precio;
        $this->estado = $estado;
        $this->descripcion = $descripcion;
    }

    public function get($campo)
    {
        return $this->$campo;
    }

    public function set($campo, $valor)
    {
        $this->$campo = $valor;
    }
}
