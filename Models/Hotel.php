<?php

namespace Models;

class Hotel
{
    private array $datos;

    public function __construct(array $datos = [])
    {
        $this->datos = $datos;
    }

    public function get(string $campo): mixed
    {
        return $this->datos[$campo] ?? null;
    }
}
