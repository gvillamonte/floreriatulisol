<?php
// ========================================================
// Order Model - Florería Tulisol
// ========================================================

class Order extends Model {
    protected string $table = 'orders';

    public function createOrderWithItems(array $orderData, array $items): ?string {
        $this->db->beginTransaction();
        try {
            // Generar código único si no viene
            if (empty($orderData['order_code'])) {
                $orderData['order_code'] = 'TLS-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
            }

            $orderId = $this->create($orderData);

            $itemStmt = $this->db->prepare("
                INSERT INTO `order_items` 
                (`order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `total_price`, `product_image`) 
                VALUES (:order_id, :product_id, :product_name, :product_price, :quantity, :total_price, :product_image)
            ");

            foreach ($items as $item) {
                $itemStmt->execute([
                    'order_id'      => $orderId,
                    'product_id'    => $item['product_id'] ?? null,
                    'product_name'  => $item['name'] ?? $item['product_name'],
                    'product_price' => $item['price'] ?? $item['product_price'],
                    'quantity'      => $item['quantity'],
                    'total_price'   => ($item['price'] ?? $item['product_price']) * $item['quantity'],
                    'product_image' => $item['image'] ?? $item['product_image'] ?? null
                ]);
            }

            $this->db->commit();
            return $orderData['order_code'];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            return null;
        }
    }

    public function findByCode(string $code): ?array {
        $order = $this->findBy('order_code', $code);
        if ($order) {
            $order['items'] = $this->getItems($order['id']);
        }
        return $order;
    }

    public function getItems(int $orderId): array {
        $sql = "SELECT * FROM `order_items` WHERE `order_id` = :oid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['oid' => $orderId]);
        return $stmt->fetchAll();
    }

    public function getDashboardStats(): array {
        // Total ventas pagadas del mes
        $sqlSales = "SELECT COALESCE(SUM(total_amount), 0) as total_sales, COUNT(*) as paid_orders 
                     FROM `orders` 
                     WHERE `payment_status` = 'paid' 
                     AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                     AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $sales = $this->db->query($sqlSales)->fetch();

        // Pedidos pendientes de atención
        $pendingCount = $this->count("order_status = 'pending'");

        // Productos activos
        $productModel = new Product();
        $totalProducts = $productModel->count("is_active = 1");

        // Total clientes únicos
        $customersCount = $this->db->query("SELECT COUNT(DISTINCT customer_email) as total FROM `orders`")->fetch()['total'] ?? 0;

        return [
            'total_sales'    => (float)($sales['total_sales'] ?? 0),
            'paid_orders'    => (int)($sales['paid_orders'] ?? 0),
            'pending_orders' => $pendingCount,
            'total_products' => $totalProducts,
            'total_clients'  => (int)$customersCount
        ];
    }

    public function getRecentOrders(int $limit = 10): array {
        $sql = "SELECT * FROM `orders` ORDER BY id DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $order['items'] = $this->getItems($order['id']);
        }
        return $orders;
    }

    public function getAllFiltered(?string $status = null, int $limit = 20, int $offset = 0): array {
        $where = "1=1";
        $params = [];

        if ($status && $status !== 'all') {
            $where .= " AND order_status = :status";
            $params['status'] = $status;
        }

        $countStmt = $this->db->prepare("SELECT COUNT(*) as total FROM `orders` WHERE {$where}");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetch()['total'];

        $sql = "SELECT * FROM `orders` WHERE {$where} ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $order['items'] = $this->getItems($order['id']);
        }

        return [
            'orders' => $orders,
            'total'  => $total,
            'pages'  => ceil($total / max(1, $limit))
        ];
    }

    public function updateOrderStatus(int $orderId, string $status): bool {
        $validStatuses = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        return $this->update($orderId, ['order_status' => $status]);
    }

    public function updatePaymentStatus(int $orderId, string $paymentStatus, ?string $chargeId = null, $details = null): bool {
        $data = ['payment_status' => $paymentStatus];
        if ($chargeId !== null) {
            $data['culqi_charge_id'] = $chargeId;
        }
        if ($details !== null) {
            $data['culqi_transaction_details'] = is_string($details) ? $details : json_encode($details);
        }
        return $this->update($orderId, $data);
    }
}
