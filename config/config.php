<?php
// ========================================================
// Configuración Global del Sistema - Florería Tulisol
// ========================================================

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Zona Horaria (Perú)
date_default_timezone_set('America/Lima');

// Rutas base del sistema de archivos
define('ROOT_PATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'app' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', ROOT_PATH . 'views' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', ROOT_PATH . 'public' . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', ROOT_PATH . 'uploads' . DIRECTORY_SEPARATOR);

// Detección dinámica de BASE_URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));

// Si el scriptName es "/" o vacío (VirtualHost raíz tipo floreriatulisol.test)
if ($scriptName === '/' || $scriptName === '' || $scriptName === '.') {
    $baseUrl = $protocol . $host;
} else {
    // Si se accede mediante subcarpeta tipo localhost/floreriatulisol
    $baseUrl = $protocol . $host . rtrim($scriptName, '/');
}
define('BASE_URL', rtrim($baseUrl, '/') . '/');

// Versión de assets para evitar cache
define('APP_VERSION', '1.0.0');

// Cargar la clase Database directamente: en Linux (InfinityFree) los nombres
// de archivo distinguen mayúsculas y el autoload no encuentra database.php
require_once __DIR__ . '/database.php';

// Autocargador simple de clases PSR-4 style para la app
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . 'Core/' . $class . '.php',
        APP_PATH . 'Helpers/' . $class . '.php',
        APP_PATH . 'Models/' . $class . '.php',
        APP_PATH . 'Controllers/' . $class . '.php',
        APP_PATH . 'Controllers/Admin/' . $class . '.php',
        APP_PATH . 'Controllers/Api/' . $class . '.php',
        ROOT_PATH . 'config/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
