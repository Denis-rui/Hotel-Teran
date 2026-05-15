<?php

namespace Controllers;

class LoginController
{
    /**
     * Valida credenciales y retorna un arreglo simple para la capa de Auth.
     */
    public function login($tipousuario, $usuario, $contrasenia)
    {
        // Limpieza basica de datos de entrada antes de consultar BD.
        $tipousuario = trim((string) $tipousuario);
        $usuario = trim((string) $usuario);
        $contrasenia = (string) $contrasenia;

        if ($tipousuario === '' || $usuario === '' || $contrasenia === '') {
            return [
                "success" => false,
                "message" => "Debe completar todos los campos"
            ];
        }

        $usuarioDAO = new \Models\UsuarioDAO();
        $user = $usuarioDAO->obtenerUsuarios($usuario);

        // Comparamos rol y contrasena. Se mantiene md5 por compatibilidad con su BD actual.
        if ($user && $tipousuario == $user["rol"]  && $user["contrasenia"] == md5($contrasenia)) {
            return [
                "success" => true,
                "message" => "Inicio de sesión exitoso",
                "rol" => $user["rol"],
                "usuario" => $user["nombre_usuario"],
                "id_usuario" => $user["id"]

            ];
        }

        return [
            "success" => false,
            "message" => "Credenciales inválidas"
        ];
    }
}
