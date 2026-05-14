<?php

namespace Api\Models;

class Reserva
{
    private $id;
    private $codigoReserva;
    private $cliente;
    private $habitacion;
    private $checkIn;
    private $checkOut;
    private $total;
    private $estado;
    private $usuario;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->cliente = $data['cliente'] ?? '';
        $this->habitacion = $data['habitacion'] ?? '';
        $this->checkIn = $data['checkIn'] ?? '';
        $this->checkOut = $data['checkOut'] ?? '';
        $this->total = $data['total'] ?? 0.0;
        $this->estado = $data['estado'] ?? 'Pendiente';
        $this->usuario = $data['usuario'] ?? '';
        $this->codigoReserva = $data['codigoReserva'] ?? $this->generarCodigoReserva();
    }

    public function get($propiedad)
    {
        return $this->$propiedad;
    }
    public function set($propiedad, $valor)
    {

        $this->$propiedad = $valor;
    }

    private function generarCodigoReserva()
    {
        return 'RES-' . strtoupper(bin2hex(random_bytes(4)));
    }
}
