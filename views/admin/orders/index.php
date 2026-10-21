<!-- ========================================================
     Gestión de Pedidos y Despachos - Florería Tulisol CMS
     ======================================================== -->

<div class="card">
    <div class="card-header">
        <div>
            <h3>Listado de Pedidos y Envíos</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Administra el ciclo de vida de los pedidos florales y pagos con Culqi.</span>
        </div>
    </div>

    <!-- Pestañas de Filtrado por Estado -->
    <div style="padding: 1rem 1.5rem 0; border-bottom: 1px solid #e2e8f0; display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <?php 
        $statuses = [
            'all' => 'Todos los Pedidos',
            'pending' => 'Pendientes',
            'confirmed' => 'Confirmados',
            'preparing' => 'En Preparación',
            'out_for_delivery' => 'En Ruta',
            'delivered' => 'Entregados',
            'cancelled' => 'Cancelados'
        ];
        ?>
        <?php foreach ($statuses as $sKey => $sLabel): ?>
            <a href="<?= BASE_URL ?>admin/pedidos?estado=<?= $sKey ?>" class="btn-admin <?= ($currentStatus === $sKey) ? 'btn-admin-primary' : 'btn-admin-secondary' ?>" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
                <?= $sLabel ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="card-body" style="padding: 0;">
        <?php if (empty($orders)): ?>
            <div style="text-align: center; padding: 4rem 1rem; color: #6d5b60;">
                <div style="margin-bottom: 0.75rem; color: #a08a90;"><?= View::icon('package', 44) ?></div>
                <h4 style="color: #332629; margin-bottom: 0.25rem;">No se encontraron pedidos con el filtro actual</h4>
                <p style="font-size: 0.85rem;">Los nuevos pedidos recibidos desde la tienda online aparecerán aquí inmediatamente.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Fecha de Entrega</th>
                            <th>Monto Total</th>
                            <th>Pago (Culqi)</th>
                            <th>Estado Pedido</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--admin-primary); font-family: monospace; font-size: 0.95rem;">
                                        <?= View::e($ord['order_code']) ?>
                                    </strong>
                                </td>
                                <td>
                                    <strong><?= View::e($ord['customer_name']) ?></strong><br>
                                    <small style="color: #64748b;"><?= View::e($ord['customer_phone']) ?></small>
                                </td>
                                <td>
                                    <?= View::e($ord['recipient_name']) ?><br>
                                    <small style="color: #64748b;"><?= View::e(substr($ord['delivery_address'], 0, 32)) ?>...</small>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($ord['delivery_date'])) ?><br>
                                    <small style="color: #64748b;"><?= View::e($ord['delivery_time_slot']) ?></small>
                                </td>
                                <td>
                                    <strong><?= View::money($ord['total_amount']) ?></strong>
                                </td>
                                <td>
                                    <span class="badge <?= ($ord['payment_status'] === 'paid') ? 'badge-paid' : 'badge-unpaid' ?>">
                                        <?= ($ord['payment_status'] === 'paid') ? 'Pagado' : 'Pendiente' ?>
                                    </span>
                                    <?php if (!empty($ord['culqi_charge_id'])): ?>
                                        <div style="font-size: 0.7rem; color: #64748b; font-family: monospace;"><?= substr($ord['culqi_charge_id'], 0, 14) ?>...</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $ord['order_status'] ?>">
                                        <?= match($ord['order_status']) {
                                            'confirmed' => 'Confirmado',
                                            'preparing' => 'En Preparación',
                                            'out_for_delivery' => 'En Ruta',
                                            'delivered' => 'Entregado',
                                            'cancelled' => 'Cancelado',
                                            default => 'Pendiente'
                                        } ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="<?= BASE_URL ?>admin/pedidos/detalle/<?= $ord['id'] ?>" class="btn-admin btn-admin-primary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                                        Ver Pedido →
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
