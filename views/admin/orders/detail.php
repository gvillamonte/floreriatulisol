<!-- ========================================================
     Detalle de Pedido - Florería Tulisol CMS
     ======================================================== -->

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <a href="<?= BASE_URL ?>admin/pedidos" class="btn-admin btn-admin-secondary" style="display: inline-flex; align-items: center; gap: 0.4rem;">
        <?= View::icon('arrow-left', 14) ?> Volver a Todos los Pedidos
    </a>
    <span style="font-size: 1.1rem; font-weight: 700; color: #332629;">
        Pedido #<?= View::e($order['order_code']) ?>
    </span>
</div>

<div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 2rem; align-items: start;">
    <!-- Columna Izquierda: Información del Envío y Productos -->
    <div>
        <!-- 1. Tarjeta Dedicatoria -->
        <?php if (!empty($order['dedication_message'])): ?>
            <div class="card" style="border: 1px dashed var(--primary); background: #fdfbf9;">
                <div class="card-header" style="background: transparent; border-bottom: 1px dashed #f5e4e8;">
                    <h3 style="color: var(--primary-dark); display: flex; align-items: center; gap: 0.5rem;">
                        <?= View::icon('mail', 18) ?> Tarjeta de Dedicatoria para Imprimir
                    </h3>
                </div>
                <div class="card-body">
                    <p style="font-size: 1.15rem; font-style: italic; color: #78350f; line-height: 1.6; margin-bottom: 0.75rem;">
                        "<?= nl2br(View::e($order['dedication_message'])) ?>"
                    </p>
                    <?php if (!empty($order['sender_signature'])): ?>
                        <div style="text-align: right; font-weight: 700; font-size: 1rem; color: #92400e;">
                            Firma: <?= View::e($order['sender_signature']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 2. Arreglos Florales Solicitados -->
        <div class="card">
            <div class="card-header">
                <h3>Arreglos Florales del Pedido</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Foto</th>
                            <th>Arreglo</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td>
                                    <?php if ($item['product_image']): ?>
                                        <img src="<?= View::upload($item['product_image']) ?>" alt="<?= View::e($item['product_name']) ?>" class="table-thumb">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong style="color: #0f172a;"><?= View::e($item['product_name']) ?></strong>
                                </td>
                                <td><?= View::money($item['product_price']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td style="text-align: right; font-weight: 700; color: var(--admin-primary);">
                                    <?= View::money($item['total_price']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span>Subtotal Productos:</span>
                        <strong><?= View::money($order['subtotal']) ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span>Costo de Envío / Delivery:</span>
                        <strong><?= View::money($order['delivery_cost']) ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: #0f172a; border-top: 2px solid #e2e8f0; padding-top: 0.75rem;">
                        <span>Total Cobrado:</span>
                        <span style="color: var(--admin-primary);"><?= View::money($order['total_amount']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Datos de Entrega -->
        <div class="card">
            <div class="card-header">
                <h3>Datos de Destino y Entrega</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; font-size: 0.95rem;">
                    <div>
                        <span style="color: #64748b; display: block; font-size: 0.8rem; text-transform: uppercase;">Destinatario(a):</span>
                        <strong style="font-size: 1.1rem; color: #0f172a;"><?= View::e($order['recipient_name']) ?></strong>
                        <?php if (!empty($order['recipient_phone'])): ?>
                            <div style="display: flex; align-items: center; gap: 0.35rem; color: #475569; margin-top: 0.25rem;">
                                <?= View::icon('phone', 14) ?> <?= View::e($order['recipient_phone']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <span style="color: #64748b; display: block; font-size: 0.8rem; text-transform: uppercase;">Programación de Entrega:</span>
                        <strong style="font-size: 1.1rem; color: #0f172a;"><?= date('d/m/Y', strtotime($order['delivery_date'])) ?></strong>
                        <div style="display: flex; align-items: center; gap: 0.35rem; color: var(--admin-primary); font-weight: 600; margin-top: 0.25rem;">
                            <?= View::icon('clock', 14) ?> <?= View::e($order['delivery_time_slot']) ?>
                        </div>
                    </div>

                    <div style="grid-column: span 2;">
                        <span style="color: #64748b; display: block; font-size: 0.8rem; text-transform: uppercase;">Dirección Exacta:</span>
                        <p style="font-size: 1rem; color: #1e293b; margin-top: 0.25rem;"><?= View::e($order['delivery_address']) ?></p>
                        <?php if (!empty($order['delivery_reference'])): ?>
                            <p style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem;"><strong>Referencia:</strong> <?= View::e($order['delivery_reference']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Estados y Pago Culqi -->
    <div>
        <!-- Cambiar Estado del Pedido -->
        <div class="card">
            <div class="card-header">
                <h3>Estado del Envío</h3>
            </div>
            <div class="card-body">
                <form action="<?= BASE_URL ?>admin/pedidos/estado/<?= $order['id'] ?>" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="order_status">Estado Actual:</label>
                        <select id="order_status" name="order_status" class="form-control" style="font-weight: 700;">
                            <option value="pending" <?= ($order['order_status'] === 'pending') ? 'selected' : '' ?>>Pendiente</option>
                            <option value="confirmed" <?= ($order['order_status'] === 'confirmed') ? 'selected' : '' ?>>Confirmado</option>
                            <option value="preparing" <?= ($order['order_status'] === 'preparing') ? 'selected' : '' ?>>En Preparación (Armado)</option>
                            <option value="out_for_delivery" <?= ($order['order_status'] === 'out_for_delivery') ? 'selected' : '' ?>>En Ruta (Despachado)</option>
                            <option value="delivered" <?= ($order['order_status'] === 'delivered') ? 'selected' : '' ?>>Entregado con Éxito</option>
                            <option value="cancelled" <?= ($order['order_status'] === 'cancelled') ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%;">
                        Actualizar Estado del Pedido
                    </button>
                </form>
            </div>
        </div>

        <!-- Información y Estado del Pago Culqi -->
        <div class="card">
            <div class="card-header">
                <h3>Pasarela Culqi / Pago</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1.25rem;">
                    <span style="color: #64748b; font-size: 0.8rem; display: block;">MÉTODO DE PAGO:</span>
                    <strong style="color: #0f172a; text-transform: uppercase;"><?= View::e($order['payment_method']) ?></strong>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <span style="color: #64748b; font-size: 0.8rem; display: block;">ID DE CARGO CULQI:</span>
                    <code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.85rem; color: #0f172a; word-break: break-all;">
                        <?= View::e($order['culqi_charge_id'] ?? 'Sin ID') ?>
                    </code>
                </div>

                <form action="<?= BASE_URL ?>admin/pedidos/pago/<?= $order['id'] ?>" method="POST" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Estado de Pago:</label>
                        <select name="payment_status" class="form-control">
                            <option value="paid" <?= ($order['payment_status'] === 'paid') ? 'selected' : '' ?>>Pagado</option>
                            <option value="pending" <?= ($order['payment_status'] === 'pending') ? 'selected' : '' ?>>Pendiente</option>
                            <option value="failed" <?= ($order['payment_status'] === 'failed') ? 'selected' : '' ?>>Fallido</option>
                            <option value="refunded" <?= ($order['payment_status'] === 'refunded') ? 'selected' : '' ?>>Reembolsado</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-secondary" style="width: 100%;">
                        Cambiar Estado de Pago
                    </button>
                </form>
            </div>
        </div>

        <!-- Datos del Remitente / Comprador -->
        <div class="card">
            <div class="card-header">
                <h3>Datos del Comprador</h3>
            </div>
            <div class="card-body" style="font-size: 0.9rem;">
                <p><strong>Nombre:</strong> <?= View::e($order['customer_name']) ?></p>
                <p style="margin-top: 0.5rem;"><strong>Email:</strong> <?= View::e($order['customer_email']) ?></p>
                <p style="margin-top: 0.5rem;"><strong>Teléfono:</strong> <?= View::e($order['customer_phone']) ?></p>
                
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <?php 
                    $wspNum = preg_replace('/[^0-9]/', '', $order['customer_phone']);
                    $msgClient = "Hola {$order['customer_name']}, te escribimos de Florería Tulisol para notificarte sobre tu pedido #{$order['order_code']}.";
                    ?>
                    <a href="https://wa.me/<?= $wspNum ?>?text=<?= urlencode($msgClient) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="width: 100%; justify-content: center; color: #15803d; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <?= View::icon('whatsapp', 16) ?> Abrir WhatsApp con el Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
