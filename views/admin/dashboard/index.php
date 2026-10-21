<!-- ========================================================
     Dashboard Principal CMS - Florería Tulisol
     ======================================================== -->

<!-- 1. Tarjetas KPI de Resumen -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-info">
            <h6>Ventas del Mes</h6>
            <div class="kpi-number"><?= View::money($stats['total_sales']) ?></div>
        </div>
        <div class="kpi-icon-wrap icon-sales"><?= View::icon('money', 24) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-info">
            <h6>Pedidos Pagados</h6>
            <div class="kpi-number"><?= $stats['paid_orders'] ?></div>
        </div>
        <div class="kpi-icon-wrap icon-orders"><?= View::icon('card', 24) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-info">
            <h6>Pedidos Pendientes</h6>
            <div class="kpi-number"><?= $stats['pending_orders'] ?></div>
        </div>
        <div class="kpi-icon-wrap icon-pending"><?= View::icon('clock', 24) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-info">
            <h6>Arreglos Activos</h6>
            <div class="kpi-number"><?= $stats['total_products'] ?></div>
        </div>
        <div class="kpi-icon-wrap icon-products"><?= View::icon('flower', 24) ?></div>
    </div>
</div>

<!-- 2. Acciones Rápidas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <a href="<?= BASE_URL ?>admin/productos/crear" style="background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #f5e4e8; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-card); transition: transform 0.2s;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fcf6f8; display: flex; align-items: center; justify-content: center; color: var(--admin-primary); border: 1px solid #f5e4e8; flex-shrink: 0;">
            <?= View::icon('plus', 20) ?>
        </div>
        <div>
            <h4 style="font-size: 1rem; color: #332629; margin-bottom: 0.2rem;">Publicar Nuevo Ramo</h4>
            <span style="font-size: 0.8rem; color: #6d5b60;">Subida y optimización a WebP</span>
        </div>
    </a>

    <a href="<?= BASE_URL ?>admin/configuracion" style="background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #f5e4e8; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-card); transition: transform 0.2s;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fcf6f8; display: flex; align-items: center; justify-content: center; color: var(--admin-primary); border: 1px solid #f5e4e8; flex-shrink: 0;">
            <?= View::icon('photo', 20) ?>
        </div>
        <div>
            <h4 style="font-size: 1rem; color: #332629; margin-bottom: 0.2rem;">Editar Logo y Marca</h4>
            <span style="font-size: 0.8rem; color: #6d5b60;">Información y redes sociales</span>
        </div>
    </a>

    <a href="<?= BASE_URL ?>admin/configuracion" style="background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #f5e4e8; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-card); transition: transform 0.2s;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fcf6f8; display: flex; align-items: center; justify-content: center; color: var(--admin-primary); border: 1px solid #f5e4e8; flex-shrink: 0;">
            <?= View::icon('card', 20) ?>
        </div>
        <div>
            <h4 style="font-size: 1rem; color: #332629; margin-bottom: 0.2rem;">Pasarela Culqi</h4>
            <span style="font-size: 0.8rem; color: #6d5b60;">Configurar llaves y billeteras</span>
        </div>
    </a>
</div>

<!-- 3. Tabla de Últimos Pedidos Recibidos -->
<div class="card">
    <div class="card-header">
        <h3>Últimos Pedidos Registrados</h3>
        <a href="<?= BASE_URL ?>admin/pedidos" class="btn-admin btn-admin-secondary">Ver Todos los Pedidos →</a>
    </div>

    <div class="card-body" style="padding: 0;">
        <?php if (empty($recentOrders)): ?>
            <div style="text-align: center; padding: 3rem 1rem; color: #6d5b60;">
                <div style="margin-bottom: 0.75rem; color: #a08a90;"><?= View::icon('package', 40) ?></div>
                <p>Aún no hay pedidos registrados en el sistema.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Cliente</th>
                            <th>Destinatario</th>
                            <th>Entrega Programada</th>
                            <th>Total</th>
                            <th>Pago (Culqi)</th>
                            <th>Estado Pedido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--admin-primary); font-family: monospace; font-size: 0.95rem;">
                                        <?= View::e($order['order_code']) ?>
                                    </strong>
                                </td>
                                <td>
                                    <strong><?= View::e($order['customer_name']) ?></strong><br>
                                    <small style="color: #64748b;"><?= View::e($order['customer_phone']) ?></small>
                                </td>
                                <td>
                                    <?= View::e($order['recipient_name']) ?><br>
                                    <small style="color: #64748b;"><?= View::e(substr($order['delivery_address'], 0, 30)) ?>...</small>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($order['delivery_date'])) ?><br>
                                    <small style="color: #64748b;"><?= View::e($order['delivery_time_slot']) ?></small>
                                </td>
                                <td>
                                    <strong><?= View::money($order['total_amount']) ?></strong>
                                </td>
                                <td>
                                    <span class="badge <?= ($order['payment_status'] === 'paid') ? 'badge-paid' : 'badge-unpaid' ?>">
                                        <?= ($order['payment_status'] === 'paid') ? 'Pagado' : 'Pendiente' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $order['order_status'] ?>">
                                        <?= match($order['order_status']) {
                                            'confirmed' => 'Confirmado',
                                            'preparing' => 'En Preparación',
                                            'out_for_delivery' => 'En Ruta',
                                            'delivered' => 'Entregado',
                                            'cancelled' => 'Cancelado',
                                            default => 'Pendiente'
                                        } ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>admin/pedidos/detalle/<?= $order['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
