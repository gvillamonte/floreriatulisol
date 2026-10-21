<?php
// ========================================================
// WhatsAppHelper - Enlaces de compra por WhatsApp
// Construye el mensaje con todos los datos del producto
// (nombre, categoría, precio, ficha e imagen) para que
// la florería tenga mayor control de cada consulta.
// ========================================================

class WhatsAppHelper {
    public const DEFAULT_NUMBER = '51932070468';

    /**
     * Normaliza el número del settings (solo dígitos, con código de país).
     */
    public static function number(?string $raw): string {
        $clean = preg_replace('/\D/', '', (string) $raw);
        return $clean ? $clean : self::DEFAULT_NUMBER;
    }

    /**
     * Mensaje precargado con los datos del producto e imagen.
     */
    public static function productMessage(array $product, ?string $baseUrl = null): string {
        $baseUrl = $baseUrl ?: BASE_URL;

        $salePrice = !empty($product['sale_price']) ? (float) $product['sale_price'] : null;
        $price     = $salePrice ?: (float) ($product['price'] ?? 0);

        $lines = [
            '¡Hola Florería Tulisol! Quiero comprar este arreglo:',
            '',
            'Producto: ' . ($product['name'] ?? ''),
        ];

        if (!empty($product['category_name'])) {
            $lines[] = 'Categoría: ' . $product['category_name'];
        }

        $lines[] = 'Precio: ' . View::money($price);
        if ($salePrice) {
            $lines[] = 'Antes: ' . View::money($product['price']);
        }

        if (!empty($product['slug'])) {
            $lines[] = '';
            $lines[] = 'Ficha: ' . rtrim($baseUrl, '/') . '/producto/' . $product['slug'];
        }
        if (!empty($product['main_image'])) {
            $lines[] = 'Imagen: ' . View::upload($product['main_image']);
        }

        return implode("\n", $lines);
    }

    /**
     * Enlace wa.me listo para abrir con el mensaje del producto.
     */
    public static function productLink(array $product, ?string $phone, ?string $baseUrl = null): string {
        $message = self::productMessage($product, $baseUrl);
        return 'https://wa.me/' . self::number($phone) . '?text=' . urlencode($message);
    }
}
