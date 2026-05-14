<?php

namespace Models;

class UsuarioDAO
{
    private $conexion;
    public function __construct()
    {

        $this->conexion = \Config\Conexion::conectar();
    }

    public function obtenerUsuarios($usuario)
    {
        try {

            $sql = "SELECT u.id, r.rol, u.nombre_usuario, u.contrasenia FROM rol r join usuario u on r.id = u.id_rol WHERE u.nombre_usuario = ? AND u.estado = 1";
            $statement = $this->conexion->prepare($sql);
            $statement->execute([$usuario]);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener usuarios: " . $e->getMessage();
            return [];
        }
    }
    public function read(string $nombreUsuario): array|false
    {
        try {
            $sql = "SELECT u.nombre_completo, u.nombre_usuario, u.correo, 
                           u.telefono, r.rol
                    FROM usuario u
                    JOIN rol r ON u.id_rol = r.id
                    WHERE u.nombre_usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$nombreUsuario]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error al leer usuario: " . $e->getMessage());
        }
    }

    public function update(string $nombreUsuario, \Api\Models\Usuario $usuario): bool
    {
        try {
            $sql = "UPDATE usuario SET 
                        nombre_completo = :nombre_completo,
                        nombre_usuario  = :nombre_usuario,
                        correo          = :correo,
                        telefono        = :telefono
                    WHERE nombre_usuario = :nombre_usuario_actual";

            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([
                ':nombre_completo'       => $usuario->get('nombre_completo'),
                ':nombre_usuario'        => $usuario->get('nombre_usuario'),
                ':correo'                => $usuario->get('correo'),
                ':telefono'              => $usuario->get('telefono'),
                ':nombre_usuario_actual' => $nombreUsuario,
            ]);
        } catch (\PDOException $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    public function create(\Api\Models\Usuario $usuario): bool
    {
        try {
            // Obtener id_rol desde el nombre del rol
            $stmtRol = $this->conexion->prepare("SELECT id FROM rol WHERE rol = ?");
            $stmtRol->execute([$usuario->get('rol')]);
            $rol = $stmtRol->fetch(\PDO::FETCH_ASSOC);

            if (!$rol) {
                die("Error: rol no encontrado");
            }

            $sql = "INSERT INTO usuario 
                        (nombre_completo, nombre_usuario, correo, telefono, dni, fecha_nacimiento, contrasenia, estado, id_rol)
                    VALUES 
                        (:nombre_completo, :nombre_usuario, :correo, :telefono, :dni, :fecha_nacimiento, :contrasenia, 1, :id_rol)";

            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([
                ':nombre_completo'  => $usuario->get('nombre_completo'),
                ':nombre_usuario'   => $usuario->get('nombre_usuario'),
                ':correo'           => $usuario->get('correo'),
                ':telefono'         => $usuario->get('telefono'),
                ':dni'              => $usuario->get('dni'),
                ':fecha_nacimiento' => $usuario->get('fecha_nacimiento'),
                ':contrasenia'      => $usuario->get('contrasenia'),
                ':id_rol'           => $rol['id'],
            ]);
        } catch (\PDOException $e) {
            die("Error al crear usuario: " . $e->getMessage());
        }
    }

    // Listar todos los usuarios
    public function readAll(): array
    {
        try {
            $sql = "SELECT u.id, u.nombre_completo, u.nombre_usuario, u.correo, 
                        u.telefono, u.dni, r.rol
                    FROM usuario u
                    JOIN rol r ON u.id_rol = r.id
                    WHERE u.estado = 1
                    ORDER BY u.id ASC";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error al listar usuarios: " . $e->getMessage());
        }
    }

    // Eliminar usuario por id
    public function delete(int $id): bool
    {
        try {
            $sql = "UPDATE usuario SET estado = 0 WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            die("Error al eliminar usuario: " . $e->getMessage());
        }
    }


    public function updateById(int $id, \Api\Models\Usuario $usuario): bool
    {
        try {
            // Obtener id_rol desde el nombre del rol
            $stmtRol = $this->conexion->prepare("SELECT id FROM rol WHERE rol = ?");
            $stmtRol->execute([$usuario->get('rol')]);
            $rol = $stmtRol->fetch(\PDO::FETCH_ASSOC);

            if (!$rol) {
                die("Error: rol no encontrado");
            }

            $sql = "UPDATE usuario SET 
                    nombre_completo = :nombre_completo,
                    nombre_usuario  = :nombre_usuario,
                    correo          = :correo,
                    telefono        = :telefono,
                    dni             = :dni,
                    id_rol          = :id_rol
                WHERE id = :id";

            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([
                ':nombre_completo' => $usuario->get('nombre_completo'),
                ':nombre_usuario'  => $usuario->get('nombre_usuario'),
                ':correo'          => $usuario->get('correo'),
                ':telefono'        => $usuario->get('telefono'),
                ':dni'             => $usuario->get('dni'),
                ':id_rol'          => $rol['id'],
                ':id'              => $id,
            ]);
        } catch (\PDOException $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }
}
