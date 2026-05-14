<?php

namespace Models;

class HotelDAO
{
    private $con;

    public function __construct()
    {
        $this->con = \Config\Conexion::conectar();
    }

    public function read(): array|false
    {
        try {
            $sql = "SELECT * FROM hotel LIMIT 1";
            $statement = $this->con->prepare($sql);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error al leer: " . $e->getMessage());
        }
    }

    public function update(Hotel $hotel): bool
    {
        try {
            $sql = "UPDATE hotel SET 
                nombre        = :nombre,
                ruc           = :ruc,
                telefono      = :telefono,
                email         = :email,
                direccion     = :direccion,
                ciudad_region = :ciudad_region,
                descripcion   = :descripcion,
                moneda        = :moneda,
                check_in      = :check_in,
                check_out     = :check_out,
                web           = :web
                LIMIT 1";

            $statement = $this->con->prepare($sql);
            return $statement->execute([
                ':nombre'        => $hotel->get('nombre'),
                ':ruc'           => $hotel->get('ruc'),
                ':telefono'      => $hotel->get('telefono'),
                ':email'         => $hotel->get('email'),
                ':direccion'     => $hotel->get('direccion'),
                ':ciudad_region' => $hotel->get('ciudad_region'),
                ':descripcion'   => $hotel->get('descripcion'),
                ':moneda'        => $hotel->get('moneda'),
                ':check_in'      => $hotel->get('check_in'),
                ':check_out'     => $hotel->get('check_out'),
                ':web'           => $hotel->get('web'),
            ]);
        } catch (\PDOException $e) {
            die("Error al actualizar: " . $e->getMessage());
        }
    }
}
