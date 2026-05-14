<?php

namespace Api\Models;

require_once '../../autoload.php';

header('Content-Type: application/json');

use Api\Models\HotelDAO;
use Api\Models\Hotel;

$hotelDAO = new HotelDAO();
$metodo   = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $hotel = $hotelDAO->read();
    echo json_encode($hotel);
} elseif ($metodo === 'POST') {
    $datos  = json_decode(file_get_contents('php://input'), true);

    $hotel  = new Hotel([
        'nombre'        => $datos['nombre'],
        'ruc'           => $datos['ruc'],
        'telefono'      => $datos['telefono'],
        'email'         => $datos['email'],
        'direccion'     => $datos['direccion'],
        'ciudad_region' => $datos['ciudad-region'],
        'descripcion'   => $datos['descripcion-slogan'],
        'moneda'        => $datos['monedas'],
        'check_in'      => $datos['check-in'],
        'check_out'     => $datos['check-out'],
        'web'           => $datos['web-redes'],
    ]);

    $ok = $hotelDAO->update($hotel);
    echo json_encode(['exito' => $ok]);
}
