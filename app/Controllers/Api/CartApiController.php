<?php
// ========================================================
// CartApiController - Gestión de Carrito vía AJAX
// Florería Tulisol
// ========================================================

class CartApiController extends Controller {
    public function get(): void {
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
            $totalItems += $item['quantity'];
        }

        $deliveryCost = (float)($this->settings['delivery_cost'] ?? 15.00);
        $total = $subtotal > 0 ? ($subtotal + $deliveryCost) : 0;

        $this->json([
            'success'      => true,
            'cart'         => array_values($cart),
            'totalItems'   => $totalItems,
            'subtotal'     => $subtotal,
            'subtotalText' => View::money($subtotal),
            'deliveryCost' => $deliveryCost,
            'deliveryText' => View::money($deliveryCost),
            'total'        => $total,
            'totalText'    => View::money($total)
        ]);
    }

    public function add(): void {
        $input = $this->getJsonInput();
        $productId = (int)($input['product_id'] ?? $this->getPost('product_id', 0));
        $quantity = max(1, (int)($input['quantity'] ?? $this->getPost('quantity', 1)));
        $dedication = trim($input['dedication'] ?? $this->getPost('dedication', ''));

        if ($productId <= 0) {
            $this->json(['success' => false, 'message' => 'Producto no válido.'], 400);
            return;
        }

        $productModel = new Product();
        $product = $productModel->find($productId);

        if (!$product || !$product['is_active']) {
            $this->json(['success' => false, 'message' => 'El arreglo floral no está disponible.'], 404);
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cartKey = (string)$productId;
        $price = $product['sale_price'] ? (float)$product['sale_price'] : (float)$product['price'];

        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
            if (!empty($dedication)) {
                $_SESSION['cart'][$cartKey]['dedication'] = $dedication;
            }
        } else {
            $_SESSION['cart'][$cartKey] = [
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'slug'       => $product['slug'],
                'price'      => $price,
                'priceText'  => View::money($price),
                'quantity'   => $quantity,
                'image'      => $product['main_image'],
                'dedication' => $dedication
            ];
        }

        $this->get(); // Retornar estado actualizado del carrito
    }

    public function update(): void {
        $input = $this->getJsonInput();
        $productId = (int)($input['product_id'] ?? 0);
        $quantity = (int)($input['quantity'] ?? 1);

        $cartKey = (string)$productId;

        if (isset($_SESSION['cart'][$cartKey])) {
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$cartKey]);
            } else {
                $_SESSION['cart'][$cartKey]['quantity'] = $quantity;
            }
        }

        $this->get();
    }

    public function remove(): void {
        $input = $this->getJsonInput();
        $productId = (int)($input['product_id'] ?? 0);
        $cartKey = (string)$productId;

        if (isset($_SESSION['cart'][$cartKey])) {
            unset($_SESSION['cart'][$cartKey]);
        }

        $this->get();
    }

    public function clear(): void {
        $_SESSION['cart'] = [];
        $this->get();
    }
}
