<?php
require __DIR__ . '/Libraries/Core/Autoload.php';
try {
    $c = new Controllers\LoginController();
    echo "OK_INSTANCIADO\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
