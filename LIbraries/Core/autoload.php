<?php

spl_autoload_register(function ($clase) {
    // Base del proyecto: subir dos niveles desde Libraries/Core
    $base = dirname(__DIR__, 2);
    $ruta = $base . '/' . str_replace('\\', '/', $clase) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
        return;
    }

    // Fallback: intentar resolver relativo a este directorio (compatibilidad)
    $rutaFallback = __DIR__ . '/' . str_replace('\\', '/', $clase) . '.php';
    if (file_exists($rutaFallback)) {
        require_once $rutaFallback;
    }
});
