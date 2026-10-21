<?php
// ========================================================
// Controller Base - Florería Tulisol MVC
// ========================================================

class Controller {
    protected array $settings = [];
    protected ?array $activeTheme = null;

    public function __construct() {
        // Cargar configuraciones del sitio para tenerlas siempre disponibles
        $this->loadGlobalSettings();
        $this->loadActiveTheme();
    }

    protected function loadGlobalSettings(): void {
        try {
            $settingModel = new Setting();
            $this->settings = $settingModel->getAllGrouped();
        } catch (Exception $e) {
            $this->settings = [];
        }
    }

    protected function loadActiveTheme(): void {
        try {
            $themeModel = new ColorTheme();
            $this->activeTheme = $themeModel->getActiveTheme();
        } catch (Exception $e) {
            $this->activeTheme = null;
        }
    }

    protected function render(string $view, array $data = [], ?string $layout = 'main'): void {
        // Inyectar configuraciones globales
        $data['settings'] = $this->settings;
        $data['baseUrl']  = BASE_URL;
        $data['cartCount'] = $this->getCartTotalCount();
        $data['activeTheme'] = $this->activeTheme;

        // Categorías activas para la barra de navegación del header
        try {
            $categoryModel = new Category();
            $data['navCategories'] = $categoryModel->getActive();
        } catch (Exception $e) {
            $data['navCategories'] = [];
        }

        View::render($view, $data, $layout);
    }

    protected function renderAdmin(string $view, array $data = []): void {
        $data['settings'] = $this->settings;
        $data['baseUrl']  = BASE_URL;
        $data['adminUser'] = $_SESSION['admin_user'] ?? null;

        View::render($view, $data, 'admin');
    }

    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function redirect(string $path): void {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            header("Location: $path");
        } else {
            header("Location: " . BASE_URL . ltrim($path, '/'));
        }
        exit;
    }

    protected function getPost(?string $key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    protected function getQuery(?string $key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    protected function getJsonInput(): array {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    protected function getCartTotalCount(): int {
        $cart = $_SESSION['cart'] ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += (int)($item['quantity'] ?? 1);
        }
        return $count;
    }
}
