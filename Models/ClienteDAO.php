<?php

namespace Models;

use PDO;

class ClienteDAO
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // LISTAR TODOS
    public function obtenerClientes()
    {
        $sql = "SELECT c.id,
                       c.nombre_completo AS nombre,
                       COALESCE(CONCAT(d.tipo_documento, ': ', d.numero_documento), '') AS documento,
                       c.correo_electronico AS gmail,
                       c.telefono,
                       c.procedencia AS nacionalidad
                FROM cliente c
                LEFT JOIN documento_identidad d ON d.id_cliente = c.id
                ORDER BY c.id DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // OBTENER POR ID
    public function obtenerClientePorId($id)
    {
        $sql = "SELECT c.id,
                       c.nombre_completo AS nombre,
                       d.tipo_documento,
                       d.numero_documento AS documento,
                       c.correo_electronico AS gmail,
                       c.telefono,
                       c.procedencia AS nacionalidad
                FROM cliente c
                LEFT JOIN documento_identidad d ON d.id_cliente = c.id
                WHERE c.id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // CREAR
    public function crearCliente($data)
    {
        $sql = "INSERT INTO cliente 
                (nombre, documento, gmail, telefono, nacionalidad, reservaciones, metodo_pago) 
                VALUES (:nombre, :documento, :gmail, :telefono, :nacionalidad, :reservaciones, :metodo_pago)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':documento' => $data['documento'],
            ':gmail' => $data['gmail'] ?? null,
            ':telefono' => $data['telefono'] ?? null,
            ':nacionalidad' => $data['nacionalidad'] ?? null,
            ':reservaciones' => $data['reservaciones'] ?? 0,
            ':metodo_pago' => $data['metodoPago'] ?? null
        ]);
    }

    // ACTUALIZAR
    public function actualizarCliente($data)
    {
        $sql = "UPDATE cliente SET 
                nombre = :nombre,
                documento = :documento,
                gmail = :gmail,
                telefono = :telefono,
                nacionalidad = :nacionalidad,
                reservaciones = :reservaciones,
                metodo_pago = :metodo_pago
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':documento' => $data['documento'],
            ':gmail' => $data['gmail'],
            ':telefono' => $data['telefono'],
            ':nacionalidad' => $data['nacionalidad'],
            ':reservaciones' => $data['reservaciones'],
            ':metodo_pago' => $data['metodoPago'],
            ':id' => $data['id']
        ]);
    }

    // ELIMINAR
    public function eliminarCliente($id)
    {
        $stmt = $this->conexion->prepare("DELETE FROM cliente WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    public function buscarClientesParaReserva($texto)
    {
        $sql = "SELECT c.id,
                              c.nombre_completo AS nombre,
                              d.numero_documento AS documento,
                              c.correo_electronico AS gmail,
                              c.telefono,
                              c.procedencia AS nacionalidad
                     FROM cliente c
                     LEFT JOIN documento_identidad d ON d.id_cliente = c.id
                     WHERE c.nombre_completo LIKE :texto
                         OR c.correo_electronico LIKE :texto
                         OR d.numero_documento LIKE :texto
                     ORDER BY c.nombre_completo ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':texto' => '%' . $texto . '%']);

        return $stmt->fetchAll();
    }
}
