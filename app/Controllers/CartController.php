<?php
// ========================================================
// CartController - Florería Tulisol
// ========================================================

class CartController extends Controller {
    public function index(): void {
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $deliveryCost = (float)($this->settings['delivery_cost'] ?? 15.00);
        $total = $subtotal + ($subtotal > 0 ? $deliveryCost : 0);

        $this->render('checkout.cart', [
            'pageTitle'    => 'Tu Carrito de Flores | Florería Tulisol',
            'cart'         => $cart,
            'subtotal'     => $subtotal,
            'deliveryCost' => $deliveryCost,
            'total'        => $total
        ]);
    }
}
