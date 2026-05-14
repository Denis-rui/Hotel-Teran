<?php

namespace Controllers;

class LoginController
{
    public function login($tipousuario, $usuario, $contrasenia)
    {
        $usuarioDAO = new \Models\UsuarioDAO();
        $user = $usuarioDAO->obtenerUsuarios($usuario);


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
