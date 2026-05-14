<?php

namespace Api\Controllers;

use Api\Models\ClienteDAO;

class ClienteController
{
    private $clienteDAO;

    public function __construct($conexion)
    {
        $this->clienteDAO = new ClienteDAO($conexion);
    }

    // LISTAR
    public function listarClientes()
    {
        return $this->clienteDAO->obtenerClientes();
    }

    // OBTENER POR ID
    public function obtenerCliente($id)
    {
        $cliente = $this->clienteDAO->obtenerClientePorId($id);

        if ($cliente) {
            return $cliente;
        } else {
            return ["error" => "Cliente no encontrado"];
        }
    }

    // CREAR
    public function crearCliente($data)
    {
        if (empty($data['nombre']) || empty($data['documento'])) {
            return ["error" => "Datos incompletos"];
        }

        $this->clienteDAO->crearCliente($data);
        return ["mensaje" => "Cliente creado correctamente"];
    }

    // ACTUALIZAR
    public function actualizarCliente($data)
    {
        if (empty($data['id'])) {
            return ["error" => "ID requerido"];
        }

        $this->clienteDAO->actualizarCliente($data);
        return ["mensaje" => "Cliente actualizado"];
    }

    // ELIMINAR
    public function eliminarCliente($id)
    {
        $filas = $this->clienteDAO->eliminarCliente($id);

        if ($filas > 0) {
            return ["mensaje" => "Cliente eliminado"];
        } else {
            return ["error" => "Cliente no encontrado"];
        }
    }
}
