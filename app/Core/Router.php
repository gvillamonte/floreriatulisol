<?php
// ========================================================
// Router - Florería Tulisol MVC
// ========================================================

class Router {
    private array $routes = [];
    private static ?Router $instance = null;

    public static function getInstance(): Router {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function get(string $path, $handler, array $middlewares = []): void {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, $handler, array $middlewares = []): void {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, $handler, array $middlewares): void {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . rtrim($pattern, '/') . '/?$#i';

        $this->routes[] = [
            'method'      => $method,
            'path'        => $path,
            'pattern'     => $pattern,
            'handler'     => $handler,
            'middlewares' => $middlewares
        ];
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Eliminar query strings
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        // Normalizar URI eliminando el subdirectorio del script si existe
        $scriptDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $trimmedUri = trim($uri, '/');

        if (!empty($scriptDir) && str_starts_with($trimmedUri, $scriptDir)) {
            $path = substr($trimmedUri, strlen($scriptDir));
        } else {
            $path = $trimmedUri;
        }

        $path = '/' . trim($path, '/');
        if ($path === '//') $path = '/';

        foreach ($this->routes as $route) {
            // Permitir que solicitudes HEAD coincidan con rutas GET
            if ($route['method'] !== $method && !($method === 'HEAD' && $route['method'] === 'GET')) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                // Ejecutar middlewares
                foreach ($route['middlewares'] as $mw) {
                    if (!$this->executeMiddleware($mw)) {
                        return;
                    }
                }

                // Filtrar solo nombres de parámetros nombrados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        // Si no encontró ruta, mostrar 404
        $this->handle404();
    }

    private function executeMiddleware(string $middleware): bool {
        if ($middleware === 'auth') {
            if (!isset($_SESSION['admin_user'])) {
                header('Location: ' . BASE_URL . 'admin/login');
                exit;
            }
        }
        return true;
    }

    private function executeHandler($handler, array $params): void {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$controllerName, $action] = explode('@', $handler);

            if (!class_exists($controllerName)) {
                die("Controlador $controllerName no encontrado.");
            }

            $controller = new $controllerName();
            if (!method_exists($controller, $action)) {
                die("Método $action no encontrado en $controllerName.");
            }

            call_user_func_array([$controller, $action], $params);
            return;
        }

        die("Manejador de ruta no válido.");
    }

    private function handle404(): void {
        http_response_code(404);
        $viewPath = VIEWS_PATH . '404.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "<h1>404 - Página no encontrada</h1><p><a href='" . BASE_URL . "'>Volver al inicio</a></p>";
        }
    }
}
