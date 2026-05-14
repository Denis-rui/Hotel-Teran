<?php

namespace Api\Models;

class ReservaDAO
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = \Api\Config\Conexion::conectar();
    }

    public function obtenerReservas()
    {
        try {
            $sql = "SELECT r.id, c.nombre_completo AS cliente, c.correo_electronico, h.numero_habitacion AS habitacion,
            r.check_in, r.check_out, r.total, r.estado,
            IFNULL(p.total_pagado, 0) AS total_pagado,

            ROUND((IFNULL(p.total_pagado, 0) / r.total) * 100, 0) AS porcentaje_pago,

            CASE 
                WHEN IFNULL(p.total_pagado, 0) = 0 THEN 0
                WHEN (IFNULL(p.total_pagado, 0) / r.total) * 100 < 50 THEN 50
                ELSE ROUND((IFNULL(p.total_pagado, 0) / r.total) * 100, 0)
            END AS porcentaje_mostrado

            FROM reserva r
            JOIN cliente c ON r.id_cliente = c.id
            JOIN habitacion h ON r.id_habitacion = h.id

            LEFT JOIN (
                SELECT id_reserva, SUM(monto) AS total_pagado
                FROM pago
                GROUP BY id_reserva
            ) p ON p.id_reserva = r.id;";
            $statement = $this->conexion->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener reservas: " . $e->getMessage();
            return [];
        }
    }

    public function actualizarEstadoReserva($idReserva, $nuevoEstado)
    {
        try {
            $sql = "UPDATE reserva SET estado = ? WHERE id = ?";
            $statement = $this->conexion->prepare($sql);
            return $statement->execute([$nuevoEstado, $idReserva]);
        } catch (\PDOException $e) {
            echo "Error al actualizar estado de reserva: " . $e->getMessage();
            return false;
        }
    }

    public function registrarReserva($reserva)
    {
        try {
            $sql = "INSERT INTO reserva (id_cliente, id_habitacion, check_in, check_out, total, estado, codigo_reserva, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $this->conexion->prepare($sql);
            return $statement->execute([
                $reserva->get('cliente'),
                $reserva->get('habitacion'),
                $reserva->get('checkIn'),
                $reserva->get('checkOut'),
                $reserva->get('total'),
                $reserva->get('estado'),
                $reserva->get('codigoReserva'),
                $reserva->get('usuario'),
            ]);
        } catch (\PDOException $e) {
            echo "Error al registrar reserva: " . $e->getMessage();
            return false;
        }
    }
}
