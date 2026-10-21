<?php
// ========================================================
// ImageOptimizer - Optimización y Conversión Estricta a WebP
// Florería Tulisol
// ========================================================

class ImageOptimizer {
    // Calidad predeterminada para WebP (balance óptimo entre nitidez floral y bajo peso)
    private const DEFAULT_QUALITY = 82;
    private const MAX_DIMENSION = 1200; // Máximo ancho o alto para arreglos florales
    private const MAX_FILE_SIZE_BYTES = 8 * 1024 * 1024; // 8MB máximo de subida bruta

    /**
     * Procesa una imagen subida por formulario, la optimiza y la guarda exclusivamente en formato .webp
     *
     * @param array $file Array $_FILES['campo']
     * @param string $subFolder Carpeta de destino relativa a uploads/ (ej: 'products', 'branding', 'categories')
     * @param int $maxDimension Dimensión máxima en píxeles (ancho o alto)
     * @param int $quality Calidad de compresión WebP (1-100)
     * @param bool $strictOnlyWebp Si es true, solo acepta archivos con extensión y MIME .webp original
     * @return array ['success' => bool, 'path' => string, 'size_kb' => float, 'error' => string]
     */
    public static function processUpload(
        array $file,
        string $subFolder = 'products',
        int $maxDimension = self::MAX_DIMENSION,
        int $quality = self::DEFAULT_QUALITY,
        bool $strictOnlyWebp = false
    ): array {
        // 1. Validar errores de subida estándar de PHP
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'error' => 'Parámetros de archivo no válidos.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['success' => false, 'error' => 'No se seleccionó ningún archivo.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['success' => false, 'error' => 'El archivo supera el tamaño máximo permitido por el servidor.'];
            default:
                return ['success' => false, 'error' => 'Error inesperado al subir la imagen.'];
        }

        // 2. Validar tamaño máximo
        if ($file['size'] > self::MAX_FILE_SIZE_BYTES) {
            return ['success' => false, 'error' => 'La imagen no debe superar los 8MB.'];
        }

        // 3. Validar tipo MIME real mediante finfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowedMimes = [
            'image/webp' => 'webp',
            'image/jpeg' => 'jpeg',
            'image/png'  => 'png'
        ];

        if ($strictOnlyWebp) {
            $allowedMimes = ['image/webp' => 'webp'];
        }

        if (!array_key_exists($mime, $allowedMimes)) {
            $msg = $strictOnlyWebp 
                ? 'Solo se aceptan imágenes en formato WebP (.webp).' 
                : 'Formato no permitido. Solo se aceptan imágenes WebP, JPG o PNG para ser optimizadas a WebP.';
            return ['success' => false, 'error' => $msg];
        }

        // 4. Crear recurso GD según el tipo de imagen
        $sourceImage = null;
        switch ($mime) {
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $sourceImage = @imagecreatefromwebp($file['tmp_name']);
                }
                break;
            case 'image/jpeg':
                $sourceImage = @imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $sourceImage = @imagecreatefrompng($file['tmp_name']);
                break;
        }

        if (!$sourceImage) {
            return ['success' => false, 'error' => 'El archivo no es una imagen válida o está dañado.'];
        }

        // 5. Obtener dimensiones originales
        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // 6. Calcular nuevas dimensiones proporcionales si excede el límite
        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
            if ($origWidth >= $origHeight) {
                $newWidth = $maxDimension;
                $newHeight = (int)round(($origHeight / $origWidth) * $maxDimension);
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int)round(($origWidth / $origHeight) * $maxDimension);
            }
        }

        // 7. Crear imagen de destino con transparencia respetada
        $targetImage = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparent = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
        imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);

        // 8. Remuestrear la imagen con alta calidad
        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        // 9. Preparar directorio de destino
        $targetDir = UPLOADS_PATH . trim($subFolder, '/\\') . DIRECTORY_SEPARATOR;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // 10. Generar nombre de archivo único con extensión obligatoria .webp
        $cleanOriginalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $slugName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cleanOriginalName)));
        $slugName = substr($slugName, 0, 40);
        $uniqueFilename = $slugName . '-' . time() . '-' . mt_rand(100, 999) . '.webp';
        $fullTargetPath = $targetDir . $uniqueFilename;

        // 11. Guardar en formato WebP con compresión de alto rendimiento
        $saved = imagewebp($targetImage, $fullTargetPath, $quality);

        // Liberar memoria GD
        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        if (!$saved || !file_exists($fullTargetPath)) {
            return ['success' => false, 'error' => 'No se pudo guardar la imagen WebP optimizada.'];
        }

        $fileSizeKb = round(filesize($fullTargetPath) / 1024, 2);
        $relativePath = 'uploads/' . trim($subFolder, '/\\') . '/' . $uniqueFilename;

        return [
            'success'   => true,
            'path'      => $relativePath,
            'filename'  => $uniqueFilename,
            'size_kb'   => $fileSizeKb,
            'width'     => $newWidth,
            'height'    => $newHeight
        ];
    }

    /**
     * Elimina una imagen anterior si existe y está dentro del directorio de subidas
     */
    public static function deletePrevious(?string $relativePath): void {
        if (empty($relativePath)) return;
        // Evitar eliminar archivos por defecto
        if (str_contains($relativePath, 'cat-') || str_contains($relativePath, 'logo.webp') || str_contains($relativePath, 'favicon.webp')) {
            return;
        }

        $fullPath = ROOT_PATH . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
