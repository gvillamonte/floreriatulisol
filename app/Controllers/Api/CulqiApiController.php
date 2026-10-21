<?php
// ========================================================
// CulqiApiController - Procesamiento de Pagos Culqi y Pedidos
// ========================================================

class CulqiApiController extends Controller {
    public function charge(): void {
        $input = $this->getJsonInput();

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $this->json(['success' => false, 'message' => 'El carrito de compras está vacío.'], 400);
            return;
        }

        // Validaciones básicas de datos de entrega
        $customerName     = trim($input['customer_name'] ?? '');
        $customerEmail    = trim($input['customer_email'] ?? '');
        $customerPhone    = trim($input['customer_phone'] ?? '');
        $recipientName    = trim($input['recipient_name'] ?? '');
        $deliveryAddress  = trim($input['delivery_address'] ?? '');
        $deliveryDate     = trim($input['delivery_date'] ?? date('Y-m-d'));
        $deliveryTimeSlot = trim($input['delivery_time_slot'] ?? 'Mañana (9:00 AM - 1:00 PM)');
        $tokenId          = trim($input['token_id'] ?? '');

        if (empty($customerName) || empty($customerEmail) || empty($customerPhone) || empty($recipientName) || empty($deliveryAddress)) {
            $this->json(['success' => false, 'message' => 'Por favor complete todos los datos requeridos de entrega y contacto.'], 422);
            return;
        }

        if (empty($tokenId)) {
            $this->json(['success' => false, 'message' => 'Token de Culqi no proporcionado.'], 400);
            return;
        }

        // Calcular montos
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $deliveryCost = (float)($this->settings['delivery_cost'] ?? 15.00);
        $totalAmount  = $subtotal + $deliveryCost;

        $orderCode = 'TLS-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        // Procesar cobro en Culqi
        $chargeResult = CulqiHelper::createCharge($tokenId, $totalAmount, $customerEmail, $orderCode, [
            'cliente'      => $customerName,
            'destinatario' => $recipientName,
            'telefono'     => $customerPhone
        ]);

        if (!$chargeResult['success']) {
            $this->json([
                'success' => false,
                'message' => $chargeResult['message'] ?? 'Hubo un error al procesar el pago con Culqi.'
            ], 402);
            return;
        }

        // Crear pedido en la base de datos
        $orderModel = new Order();
        $orderData = [
            'order_code'                => $orderCode,
            'customer_name'             => $customerName,
            'customer_email'            => $customerEmail,
            'customer_phone'            => $customerPhone,
            'recipient_name'            => $recipientName,
            'recipient_phone'           => trim($input['recipient_phone'] ?? ''),
            'delivery_address'          => $deliveryAddress,
            'delivery_reference'        => trim($input['delivery_reference'] ?? ''),
            'delivery_date'             => $deliveryDate,
            'delivery_time_slot'        => $deliveryTimeSlot,
            'dedication_message'        => trim($input['dedication_message'] ?? ''),
            'sender_signature'          => trim($input['sender_signature'] ?? ''),
            'subtotal'                  => $subtotal,
            'delivery_cost'             => $deliveryCost,
            'total_amount'              => $totalAmount,
            'currency'                  => 'PEN',
            'payment_method'            => 'culqi',
            'payment_status'            => 'paid',
            'culqi_charge_id'           => $chargeResult['charge_id'],
            'culqi_transaction_details' => json_encode($chargeResult['data']),
            'order_status'              => 'confirmed'
        ];

        $createdCode = $orderModel->createOrderWithItems($orderData, $cart);

        if (!$createdCode) {
            $this->json(['success' => false, 'message' => 'El pago fue procesado pero hubo un error al registrar el pedido.'], 500);
            return;
        }

        // Vaciar carrito
        $_SESSION['cart'] = [];

        $this->json([
            'success'      => true,
            'order_code'   => $orderCode,
            'redirect_url' => BASE_URL . 'pedido/confirmacion/' . $orderCode,
            'message'      => '¡Pago procesado con éxito!'
        ]);
    }

    public function offlineOrder(): void {
        $input = $this->getJsonInput();
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $this->json(['success' => false, 'message' => 'El carrito está vacío.'], 400);
            return;
        }

        $customerName     = trim($input['customer_name'] ?? '');
        $customerEmail    = trim($input['customer_email'] ?? '');
        $customerPhone    = trim($input['customer_phone'] ?? '');
        $recipientName    = trim($input['recipient_name'] ?? '');
        $deliveryAddress  = trim($input['delivery_address'] ?? '');
        $deliveryDate     = trim($input['delivery_date'] ?? date('Y-m-d'));
        $deliveryTimeSlot = trim($input['delivery_time_slot'] ?? 'Mañana');

        if (empty($customerName) || empty($customerPhone) || empty($recipientName) || empty($deliveryAddress)) {
            $this->json(['success' => false, 'message' => 'Complete los datos obligatorios de envío.'], 422);
            return;
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $deliveryCost = (float)($this->settings['delivery_cost'] ?? 15.00);
        $totalAmount  = $subtotal + $deliveryCost;

        $orderCode = 'TLS-WSP-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        $orderModel = new Order();
        $orderData = [
            'order_code'         => $orderCode,
            'customer_name'      => $customerName,
            'customer_email'     => $customerEmail ?: 'whatsapp@cliente.com',
            'customer_phone'     => $customerPhone,
            'recipient_name'     => $recipientName,
            'recipient_phone'    => trim($input['recipient_phone'] ?? ''),
            'delivery_address'   => $deliveryAddress,
            'delivery_reference' => trim($input['delivery_reference'] ?? ''),
            'delivery_date'      => $deliveryDate,
            'delivery_time_slot' => $deliveryTimeSlot,
            'dedication_message' => trim($input['dedication_message'] ?? ''),
            'sender_signature'   => trim($input['sender_signature'] ?? ''),
            'subtotal'           => $subtotal,
            'delivery_cost'      => $deliveryCost,
            'total_amount'       => $totalAmount,
            'currency'           => 'PEN',
            'payment_method'     => 'transferencia_yape',
            'payment_status'     => 'pending',
            'order_status'       => 'pending'
        ];

        $createdCode = $orderModel->createOrderWithItems($orderData, $cart);
        $_SESSION['cart'] = [];

        $this->json([
            'success'      => true,
            'order_code'   => $orderCode,
            'redirect_url' => BASE_URL . 'pedido/confirmacion/' . $orderCode,
            'message'      => 'Pedido registrado exitosamente.'
        ]);
    }
}
