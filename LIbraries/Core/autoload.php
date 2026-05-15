<?php

spl_autoload_register(function ($clase) {
    // Base del proyecto: subir dos niveles desde LIbraries/Core.
    $base = dirname(__DIR__, 2);
    $ruta = $base . '/' . str_replace('\\', '/', $clase) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
        return;
    }

    // Compatibilidad temporal: si moviste clases a Models/DAO o Models/Entidades
    // y todavia usas namespace Models\Clase, buscamos por nombre de clase.
    $partes = explode('\\', $clase);
    $nombreClase = end($partes);
    $rutasCompatibles = [
        $base . '/Models/DAO/' . $nombreClase . '.php',
        $base . '/Models/Entidades/' . $nombreClase . '.php',
    ];

    foreach ($rutasCompatibles as $rutaCompatible) {
        if (file_exists($rutaCompatible)) {
            require_once $rutaCompatible;
            return;
        }
    }

    // Fallback: intentar resolver relativo a este directorio (compatibilidad)
    $rutaFallback = __DIR__ . '/' . str_replace('\\', '/', $clase) . '.php';
    if (file_exists($rutaFallback)) {
        require_once $rutaFallback;
    }
});
