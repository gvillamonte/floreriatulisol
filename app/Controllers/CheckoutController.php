<?php
// ========================================================
// CheckoutController - Florería Tulisol
// ========================================================

class CheckoutController extends Controller {
    public function index(): void {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $this->redirect('catalogo');
            return;
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $deliveryCost = (float)($this->settings['delivery_cost'] ?? 15.00);
        $total = $subtotal + $deliveryCost;

        $this->render('checkout.index', [
            'pageTitle'       => 'Finalizar Compra | Florería Tulisol',
            'cart'            => $cart,
            'subtotal'        => $subtotal,
            'deliveryCost'    => $deliveryCost,
            'total'           => $total,
            'culqiPublicKey'  => $this->settings['culqi_public_key'] ?? 'pk_test_a0d8b3684a0d9239',
            'culqiMode'       => $this->settings['culqi_mode'] ?? 'test'
        ]);
    }

    public function confirmation(string $code): void {
        $orderModel = new Order();
        $order = $orderModel->findByCode($code);

        if (!$order) {
            $this->redirect('');
            return;
        }

        $this->render('checkout.confirmation', [
            'pageTitle' => '¡Pedido Confirmado! #' . $order['order_code'] . ' | Florería Tulisol',
            'order'     => $order
        ]);
    }
}
