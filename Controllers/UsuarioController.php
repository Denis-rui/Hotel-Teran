<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../autoload.php';

use Models\UsuarioDAO;
use Models\Usuario;

$usuarioDAO = new UsuarioDAO();
$metodo     = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $accion = $_GET['accion'] ?? '';

    if ($accion === 'listar') {
        $usuarios = $usuarioDAO->readAll();
        echo json_encode($usuarios);
    } else {
        $nombreUsuario = $_SESSION["nombreUsuario"] ?? '';
        if (empty($nombreUsuario)) {
            echo json_encode(["error" => "No hay sesión activa"]);
            exit;
        }
        $usuario = $usuarioDAO->read($nombreUsuario);
        echo json_encode($usuario);
    }
} elseif ($metodo === 'POST') {
    $datos  = json_decode(file_get_contents('php://input'), true);
    $accion = $datos['accion'] ?? '';

    if ($accion === 'crear') {
        $usuario = new Usuario([
            'nombre_completo'  => $datos['nombre_completo'],
            'nombre_usuario'   => $datos['nombre_usuario'],
            'correo'           => $datos['correo'],
            'telefono'         => $datos['telefono'],
            'dni'              => $datos['dni'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'contrasenia'      => $datos['contrasenia'],
            'rol'              => $datos['rol'],
        ]);
        $ok = $usuarioDAO->create($usuario);
        echo json_encode(['exito' => $ok]);
    } elseif ($accion === 'actualizar') {
        // Actualizar perfil propio
        $nombreUsuario = $_SESSION["nombreUsuario"] ?? '';
        if (empty($nombreUsuario)) {
            echo json_encode(["error" => "No hay sesión activa"]);
            exit;
        }
        $usuario = new Usuario([
            'nombre_completo' => $datos['nombre_completo'],
            'nombre_usuario'  => $datos['nombre_usuario'],
            'correo'          => $datos['correo'],
            'telefono'        => $datos['telefono'],
        ]);
        $ok = $usuarioDAO->update($nombreUsuario, $usuario);
        if ($ok && isset($datos['nombre_usuario'])) {
            $_SESSION["nombreUsuario"] = $datos['nombre_usuario'];
        }
        echo json_encode(['exito' => $ok]);
    } elseif ($accion === 'actualizar_admin') {
        // Actualizar usuario desde módulo de Usuarios
        $usuario = new Usuario([
            'nombre_completo' => $datos['nombre_completo'],
            'nombre_usuario'  => $datos['nombre_usuario'],
            'correo'          => $datos['correo'],
            'telefono'        => $datos['telefono'],
            'dni'             => $datos['dni'],
            'rol'             => $datos['rol'],
        ]);
        $ok = $usuarioDAO->updateById((int) $datos['id'], $usuario);
        echo json_encode(['exito' => $ok]);
    } elseif ($accion === 'eliminar') {
        $ok = $usuarioDAO->delete((int) $datos['id']);
        echo json_encode(['exito' => $ok]);
    }
}
