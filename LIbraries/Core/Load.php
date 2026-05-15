<?php
$controllerFile = "Controllers/{$controlador}Controller.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Prioridad: clases bajo namespace Controllers (estructura MVC actual).
    $controllerClass = "Controllers\\" . $controlador . "Controller";
    if (!class_exists($controllerClass)) {
        // Compatibilidad con controladores antiguos sin namespace.
        $controllerClass = $controlador . "Controller";
    }

    $controllerObject = new $controllerClass();

    if (method_exists($controllerObject, $metodo)) {
        // Si no hay parametros, invocamos metodo sin argumentos.
        if ($parametros === "" || $parametros === null) {
            $controllerObject->$metodo();
        } else {
            $paramsArray = array_map('trim', explode(',', $parametros));
            $controllerObject->$metodo(...$paramsArray);
        }
    } else {
        echo "Error: Método '{$metodo}' no encontrado en el controlador '{$controlador}'";
    }
} else {
    echo "Error: Controlador '{$controlador}' no encontrado";
}
