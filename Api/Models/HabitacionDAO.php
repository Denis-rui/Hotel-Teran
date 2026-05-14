<?php

namespace Api\Models;

use Api\Config\Conexion;


class HabitacionDAO
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }


    //CREATE — Inserta una nueva habitación.

    public function insert($habitacion)
    {
        try {
            $sql = "INSERT INTO habitacion (numero_habitacion, id_tipo_habitacion, precio, estado, descripcion_habitacion) VALUES (?,?,?,?,?)";

            $statement = $this->conexion->prepare($sql);
            return $statement->execute([
                $habitacion->get('numero_habitacion'),
                $habitacion->get('id_tipo_habitacion'),
                $habitacion->get('precio'),
                $habitacion->get('estado'),
                $habitacion->get('descripcion')

            ]);
        } catch (\PDOException $e) {
            die("Error de conexion: " . $e->getMessage());
        }
    }

    // Read - para realizar las busquedas

    public function readFiltro($habitacion)
    {
        try {
            // Hacemos join con la tabla de tipos para poder mostrar el nombre del tipo
            $sql = "SELECT h.id, h.numero_habitacion,
            t.tipo AS tipo_nombre, h.descripcion_habitacion AS descripcion, h.precio, h.estado
            FROM habitacion h 
            JOIN `tipo_habitación` t ON t.id = h.id_tipo_habitacion
            WHERE 1=1";

            $params = [];

            // Filtro por número 
            if ($habitacion->get('numero_habitacion') !== null && $habitacion->get('numero_habitacion') !== '') {
                $sql .= " AND h.numero_habitacion LIKE ?";
                $params[] = "%" . $habitacion->get('numero_habitacion') . "%";
            }


            // Filtro por tipo
            if ($habitacion->get('id_tipo_habitacion')) {
                $tipoFiltro = $habitacion->get('id_tipo_habitacion');
                if (is_numeric($tipoFiltro)) {
                    $sql .= " AND h.id_tipo_habitacion = ?";
                    $params[] = $tipoFiltro;
                } else {
                    // buscar por nombre del tipo (ej: 'Simple')
                    $sql .= " AND t.tipo LIKE ?";
                    $params[] = "%" . $tipoFiltro . "%";
                }
            }

            // Filtro por estado
            if ($habitacion->get('estado')) {
                $sql .= " AND h.estado = ?";
                $params[] = $habitacion->get('estado');
            }

            $sql .= " ORDER BY h.numero_habitacion ASC";

            $statement = $this->conexion->prepare($sql);
            $statement->execute($params);

            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function updateEstado($id, $estado)
    {
        try {
            $sql = "UPDATE habitacion SET estado = ? WHERE id = ?";
            $statement = $this->conexion->prepare($sql);
            return $statement->execute([$estado, $id]);
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function obtenerFiltros()
    {
        try {
            $filtros = [];

            // Tipos de habitación
            $sqlTipos = "SELECT id, tipo FROM `tipo_habitación` ORDER BY tipo ASC";
            $stmtTipos = $this->conexion->prepare($sqlTipos);
            $stmtTipos->execute();
            $filtros['tipos'] = $stmtTipos->fetchAll(\PDO::FETCH_ASSOC);

            // Estados (puedes ajustarlos según tu BD)
            $sqlEstados = "SELECT DISTINCT estado FROM habitacion";
            $stmtEstados = $this->conexion->prepare($sqlEstados);
            $stmtEstados->execute();
            $filtros['estados'] = $stmtEstados->fetchAll(\PDO::FETCH_COLUMN);

            return $filtros;
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function habitacionesDisponibles()
    {
        try {
            $sql = "SELECT h.id, h.numero_habitacion,
    t.tipo AS tipo_nombre, h.precio,h.estado
    FROM habitacion h 
    JOIN `tipo_habitación` t ON t.id = h.id_tipo_habitacion
    WHERE 1=1";
            $statement = $this->conexion->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
