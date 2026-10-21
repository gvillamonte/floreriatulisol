<?php
// ========================================================
// View - Florería Tulisol MVC
// ========================================================

class View {
    public static function render(string $view, array $data = [], ?string $layout = 'main'): void {
        extract($data);

        $viewFile = VIEWS_PATH . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            die("Vista no encontrada: $viewFile");
        }

        // Si no se especifica layout, renderizar directamente la vista
        if ($layout === null) {
            require $viewFile;
            return;
        }

        // Capturar contenido de la vista
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Renderizar el layout maestro
        $layoutFile = VIEWS_PATH . 'layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    public static function e(?string $str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }

    public static function money($amount): string {
        return 'S/ ' . number_format((float)$amount, 2, '.', ',');
    }

    public static function asset(string $path): string {
        return BASE_URL . 'public/' . ltrim($path, '/') . '?v=' . APP_VERSION;
    }

    public static function upload(?string $path, string $default = 'uploads/branding/logo.webp'): string {
        if (empty($path)) {
            return BASE_URL . $default;
        }
        return BASE_URL . ltrim($path, '/');
    }

    public static function icon(string $name, int $size = 18, string $class = ''): string {
        return IconHelper::render($name, $size, $class);
    }
}
