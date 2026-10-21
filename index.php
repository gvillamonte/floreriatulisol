<?php
// ========================================================
// Front Controller - Florería Tulisol MVC
// ========================================================

require_once __DIR__ . '/config/error_handler.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/routes.php';

// Despachar la solicitud
$router->dispatch();
