<?php
// ========================================================
// OrderController - Gestión de Pedidos en el CMS
// Florería Tulisol
// ========================================================

class OrderController extends Controller {
    public function index(): void {
        $orderModel = new Order();
        $status = $this->getQuery('estado', 'all');
        $page = max(1, (int)$this->getQuery('pagina', 1));
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $result = $orderModel->getAllFiltered($status, $limit, $offset);

        $this->renderAdmin('admin.orders.index', [
            'pageTitle'     => 'Gestión de Pedidos | Florería Tulisol CMS',
            'orders'        => $result['orders'],
            'total'         => $result['total'],
            'pages'         => $result['pages'],
            'currentPage'   => $page,
            'currentStatus' => $status
        ]);
    }

    public function detail(string $id): void {
        $orderModel = new Order();
        $order = $orderModel->find((int)$id);

        if (!$order) {
            Session::setFlash('error', 'Pedido no encontrado.');
            $this->redirect('admin/pedidos');
            return;
        }

        $order['items'] = $orderModel->getItems((int)$id);

        $this->renderAdmin('admin.orders.detail', [
            'pageTitle' => 'Pedido #' . $order['order_code'] . ' | Florería Tulisol CMS',
            'order'     => $order
        ]);
    }

    public function updateStatus(string $id): void {
        $newStatus = trim($this->getPost('order_status', ''));
        $orderModel = new Order();

        if ($orderModel->updateOrderStatus((int)$id, $newStatus)) {
            Session::setFlash('success', 'Estado del pedido actualizado exitosamente.');
        } else {
            Session::setFlash('error', 'No se pudo actualizar el estado del pedido.');
        }

        $this->redirect("admin/pedidos/detalle/{$id}");
    }

    public function updatePayment(string $id): void {
        $newPayment = trim($this->getPost('payment_status', ''));
        $orderModel = new Order();

        if ($orderModel->updatePaymentStatus((int)$id, $newPayment)) {
            Session::setFlash('success', 'Estado de pago actualizado.');
        } else {
            Session::setFlash('error', 'No se pudo actualizar el pago.');
        }

        $this->redirect("admin/pedidos/detalle/{$id}");
    }
}
