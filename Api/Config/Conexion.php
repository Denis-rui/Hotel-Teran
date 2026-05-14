<?php

namespace Api\Config;

class Conexion
{
    private static $host = "localhost";
    private static $user = "root";
    private static $pass = "";
    private static $db_name = "hotel_teran";

    public static function conectar()
    {
        try {
            $conexion = new \PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$user, self::$pass);
            $conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
