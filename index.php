<?php
session_start();
require_once 'config/config.php';
require_once 'config/Database.php';

// Carga automática de controladores y modelos básicos (Simple Autoloader)
spl_autoload_register(function ($class_name) {
    if (file_exists('controllers/' . $class_name . '.php')) {
        require_once 'controllers/' . $class_name . '.php';
    } else if (file_exists('models/' . $class_name . '.php')) {
        require_once 'models/' . $class_name . '.php';
    }
});

// Enrutador básico
$controller = isset($_GET['c']) ? $_GET['c'] : 'Home';
$action = isset($_GET['a']) ? $_GET['a'] : 'index';

$controllerName = $controller . 'Controller';

if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        echo "Acción no encontrada: 404";
    }
} else {
    // Fallback a controlador por defecto si no existe
    if (class_exists('HomeController')) {
        $controllerInstance = new HomeController();
        $controllerInstance->index();
    } else {
        echo "Página de inicio en construcción. Bienvenido a " . APP_NAME;
    }
}
