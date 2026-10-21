<?php
// ========================================================
// CulqiHelper - Integración Pasarela de Pagos Culqi
// Soporta Tarjetas de Crédito/Débito y Billeteras Digitales (Yape, Plin)
// ========================================================

class CulqiHelper {
    private const CULQI_API_URL = 'https://api.culqi.com/v2/charges';

    /**
     * Procesa un cobro a través de la API de Culqi
     *
     * @param string $tokenId Token generado por Culqi Checkout (tarjeta o Yape)
     * @param float $amountMonto Monto en Soles (PEN)
     * @param string $email Correo electrónico del pagador
     * @param string $orderCode Código único del pedido (ej. TLS-20261013-1234)
     * @param array $metadata Datos adicionales del pedido
     * @return array ['success' => bool, 'charge_id' => string, 'data' => array, 'message' => string]
     */
    public static function createCharge(
        string $tokenId,
        float $amountMonto,
        string $email,
        string $orderCode,
        array $metadata = []
    ): array {
        $settingModel = new Setting();
        $secretKey = $settingModel->get('culqi_secret_key', 'sk_test_7f1c137baef9f4a1');
        $currencyCode = $settingModel->get('currency_code', 'PEN');

        // Culqi requiere el monto en centavos (entero)
        $amountInCents = (int)round($amountMonto * 100);

        $payload = [
            'amount'        => $amountInCents,
            'currency_code' => $currencyCode,
            'email'         => $email,
            'source_id'     => $tokenId,
            'description'   => "Pedido en Florería Tulisol #{$orderCode}",
            'metadata'      => array_merge(['order_code' => $orderCode], $metadata)
        ];

        // Si es un token simulado para pruebas locales o si la clave es de prueba y no hay internet
        if (str_starts_with($tokenId, 'tkn_simulated_') || empty($secretKey)) {
            return [
                'success'   => true,
                'charge_id' => 'chr_sim_' . bin2hex(random_bytes(10)),
                'data'      => [
                    'id'               => 'chr_sim_' . bin2hex(random_bytes(10)),
                    'amount'           => $amountInCents,
                    'outcome'          => ['type' => 'venta_exitosa'],
                    'reference_code'   => $orderCode,
                    'source'           => ['card_number' => '**** **** **** 4242']
                ],
                'message'   => 'Pago procesado exitosamente (Modo Simulación).'
            ];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::CULQI_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $secretKey
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'charge_id' => null,
                'data' => null,
                'message' => 'Error de comunicación con Culqi: ' . $curlError
            ];
        }

        $result = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && isset($result['id'])) {
            return [
                'success'   => true,
                'charge_id' => $result['id'],
                'data'      => $result,
                'message'   => 'Pago procesado exitosamente con Culqi.'
            ];
        }

        $userMessage = $result['user_message'] ?? $result['merchant_message'] ?? 'No se pudo procesar el pago con Culqi.';
        return [
            'success'   => false,
            'charge_id' => null,
            'data'      => $result,
            'message'   => $userMessage
        ];
    }
}
