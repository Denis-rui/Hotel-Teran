<?php

namespace Models;

class Usuario
{
    private string $nombre_completo;
    private string $nombre_usuario;
    private string $correo;
    private string $telefono;
    private string $dni;
    private string $fecha_nacimiento;
    private string $contrasenia;
    private int    $estado;
    private string $rol;

    public function __construct(array $datos = [])
    {
        $this->nombre_completo  = $datos['nombre_completo']  ?? '';
        $this->nombre_usuario   = $datos['nombre_usuario']   ?? '';
        $this->correo           = $datos['correo']           ?? '';
        $this->telefono         = $datos['telefono']         ?? '';
        $this->dni              = $datos['dni']              ?? '';
        $this->fecha_nacimiento = $datos['fecha_nacimiento'] ?? '';
        $this->contrasenia      = $datos['contrasenia']      ?? '';
        $this->estado           = $datos['estado']           ?? 1;
        $this->rol              = $datos['rol']              ?? '';
    }

    public function get(string $campo): mixed
    {
        return $this->$campo ?? null;
    }

    public function set(string $campo, mixed $valor): void
    {
        $this->$campo = $valor;
    }
}
