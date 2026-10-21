<?php
// ========================================================
// Handler Global de Errores - Florería Tulisol
// Muestra el error real en pantalla en vez del 500 en blanco.
// Se carga ANTES que config.php desde index.php.
// ========================================================

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');

// ¿La petición espera JSON (API)? Detectamos por URI o Accept
function err_wants_json(): bool
{
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (str_contains($uri, '/api/')) {
        return true;
    }
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    return str_contains($accept, 'application/json');
}

// Renderiza el error como HTML legible
function err_output(string $titulo, string $mensaje, string $archivo = '', int $linea = 0, string $traza = ''): void
{
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    $tituloEsc = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    $mensajeEsc = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    $archivoEsc = htmlspecialchars($archivo, ENT_QUOTES, 'UTF-8');
    $trazaEsc = htmlspecialchars($traza, ENT_QUOTES, 'UTF-8');
    $ubicacion = $archivo !== '' ? " en <strong>{$archivoEsc}</strong>" . ($linea > 0 ? " línea <strong>{$linea}</strong>" : '') : '';
    $trazaBlock = $trazaEsc !== '' ? '<pre>' . $trazaEsc . '</pre>' : '';
    echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>500 - Error del servidor</title>
<style>
    body { font-family: -apple-system, "Segoe UI", Roboto, Arial, sans-serif; background:#1a1a2e; color:#eee; margin:0; padding:2rem; }
    .card { max-width: 900px; margin: 2rem auto; background:#16213e; border:1px solid #e94560; border-radius:8px; padding:1.5rem 2rem; }
    h1 { color:#e94560; font-size:1.4rem; margin-top:0; }
    .msg { background:#0f3460; border-left:4px solid #e94560; padding:1rem; font-size:1.05rem; word-break:break-word; margin:1rem 0; }
    .meta { color:#aaa; font-size:.9rem; }
    pre { background:#0d1b2a; border:1px solid #333; border-radius:6px; padding:1rem; overflow:auto; font-size:.8rem; color:#9fcdff; white-space:pre-wrap; }
    .footer { margin-top:1.5rem; color:#777; font-size:.8rem; }
</style>
</head>
<body>
<div class="card">
    <h1>500 - Error del servidor</h1>
    <div class="meta">Tipo de error: <strong>{$tituloEsc}</strong>{$ubicacion}</div>
    <div class="msg">{$mensajeEsc}</div>
    {$trazaBlock}
    <div class="footer">Este mensaje se muestra temporalmente para depuración. Bájalo cuando el sitio funcione.</div>
</div>
</body>
</html>
HTML;
}

// Para APIs: respuesta JSON
function err_output_json(string $titulo, string $mensaje, string $archivo = '', int $linea = 0): void
{
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'error'   => $titulo,
        'message' => $mensaje,
        'file'    => $archivo,
        'line'    => $linea,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

// ----------------------------------------------------------
// 1) Excepciones no capturadas
// ----------------------------------------------------------
set_exception_handler(function (Throwable $e) {
    $titulo = get_class($e);
    $mensaje = $e->getMessage();
    $archivo = $e->getFile();
    $linea = $e->getLine();
    $traza = $e->getTraceAsString();
    error_log("[Excepción no capturada] $titulo: $mensaje en $archivo:$linea");

    if (err_wants_json()) {
        err_output_json($titulo, $mensaje, $archivo, $linea);
    } else {
        err_output($titulo, $mensaje, $archivo, $linea, $traza);
    }
});

// ----------------------------------------------------------
// 2) Warnings / notices / deprecations: se registran en el log
//    del servidor (error_log) sin cortar la ejecución.
// ----------------------------------------------------------
set_error_handler(function (int $no, string $str, string $file = '', int $line = 0) {
    if (!(error_reporting() & $no)) {
        return false;
    }
    error_log("[PHP] $str en $file:$line");
    return true;
});

// ----------------------------------------------------------
// 3) Errores fatales (E_ERROR, E_PARSE, OOM, etc.)
//    Esto es lo que produce el 500 en blanco en InfinityFree
// ----------------------------------------------------------
register_shutdown_function(function () {
    $e = error_get_last();
    if ($e === null) {
        return;
    }
    $fatales = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR];
    if (!in_array($e['type'], $fatales, true)) {
        return;
    }
    $tipos = [
        E_ERROR             => 'Error fatal (E_ERROR)',
        E_PARSE             => 'Error de sintaxis (E_PARSE)',
        E_CORE_ERROR        => 'Error del core de PHP (E_CORE_ERROR)',
        E_COMPILE_ERROR     => 'Error de compilación (E_COMPILE_ERROR)',
        E_USER_ERROR        => 'Error del usuario (E_USER_ERROR)',
        E_RECOVERABLE_ERROR => 'Error recuperable (E_RECOVERABLE_ERROR)',
    ];
    $titulo = $tipos[$e['type']] ?? 'Error fatal';
    error_log("[Fatal] {$e['message']} en {$e['file']}:{$e['line']}");

    if (err_wants_json()) {
        err_output_json($titulo, $e['message'], $e['file'], $e['line']);
    } else {
        err_output($titulo, $e['message'], $e['file'], $e['line']);
    }
});
