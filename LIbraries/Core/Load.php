<?php
$controllerFile = "Controllers/{$controlador}Controller.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = $controlador . "Controller";
    $controllerObject = new $controllerClass();
    if (method_exists($controllerObject, $metodo)) {
        $controllerObject->$metodo($parametros);
    } else {
        echo "Error: Método '{$metodo}' no encontrado en el controlador '{$controlador}'";
    }
} else {
    echo "Error: Controlador '{$controlador}' no encontrado";
}
