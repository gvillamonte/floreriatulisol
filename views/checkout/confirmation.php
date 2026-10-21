<!-- ========================================================
     Confirmación de Pedido - Florería Tulisol
     ======================================================== -->

<div class="container" style="padding: 4.5rem 1.25rem 6rem; max-width: 820px;">
    <div style="background: #fff; border-radius: 20px; padding: 3rem 2.5rem; box-shadow: var(--shadow-md); border: 1px solid #e2e8f0; text-align: center;">
        
        <!-- Icono de Éxito -->
        <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--secondary-lighter); color: var(--secondary-dark); border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
            <?= View::icon('check', 36) ?>
        </div>

        <span class="section-badge">¡Muchas Gracias por tu Compra!</span>
        <h1 style="font-size: 2.25rem; color: var(--text-main); margin-bottom: 0.75rem;">¡Tu Pedido ha sido Registrado con Éxito!</h1>
        <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 2rem;">
            Código de Seguimiento: <strong style="color: var(--primary-dark); font-size: 1.25rem; background: var(--primary-subtle); border: 1px solid var(--border-color); padding: 0.25rem 0.75rem; border-radius: 8px;"><?= View::e($order['order_code']) ?></strong>
        </p>

        <!-- Estado del Pago -->
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 2.5rem; padding: 0.5rem 1.25rem; border-radius: 9999px; font-weight: 700; font-size: 0.9rem; <?= ($order['payment_status'] === 'paid') ? 'background: var(--secondary-lighter); color: var(--secondary-dark); border: 1px solid var(--secondary-light);' : 'background: #faf4ed; color: #6d544c; border: 1px solid #ebdcd1;' ?>">
            <?php if ($order['payment_status'] === 'paid'): ?>
                <span>Pago Confirmado vía Culqi (ID: <?= View::e($order['culqi_charge_id'] ?? 'Aprobado') ?>)</span>
            <?php else: ?>
                <span>Pago Pendiente de Verificación</span>
            <?php endif; ?>
        </div>

        <!-- Tarjeta de Resumen Detallado -->
        <div style="text-align: left; background: #fff; border-radius: 14px; padding: 1.75rem; border: 1px solid var(--border-color); margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.15rem; color: var(--text-main); margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                Detalles del Envío Floral
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.925rem;">
                <div>
                    <span style="color: var(--text-muted); display: block;">Destinatario:</span>
                    <strong style="color: var(--text-main);"><?= View::e($order['recipient_name']) ?></strong>
                </div>
                <div>
                    <span style="color: var(--text-muted); display: block;">Fecha y Turno:</span>
                    <strong style="color: var(--text-main);"><?= date('d/m/Y', strtotime($order['delivery_date'])) ?> - <?= View::e($order['delivery_time_slot']) ?></strong>
                </div>
                <div style="grid-column: span 2;">
                    <span style="color: var(--text-muted); display: block;">Dirección de Entrega:</span>
                    <strong style="color: var(--text-main);"><?= View::e($order['delivery_address']) ?></strong>
                    <?php if (!empty($order['delivery_reference'])): ?>
                        <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Ref: <?= View::e($order['delivery_reference']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Dedicatoria -->
            <?php if (!empty($order['dedication_message'])): ?>
                <div style="background: #fdfaf8; border: 1px dashed var(--accent-champagne); padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: #6d544c; text-transform: uppercase;">Tarjeta Dedicatoria Impresa:</span>
                    <p style="font-style: italic; color: #523e37; margin-top: 0.35rem; font-size: 0.95rem;">
                        "<?= nl2br(View::e($order['dedication_message'])) ?>"
                    </p>
                    <?php if (!empty($order['sender_signature'])): ?>
                        <div style="text-align: right; font-weight: 700; color: #6d544c; font-size: 0.875rem; margin-top: 0.35rem;">
                            — <?= View::e($order['sender_signature']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Lista de Arreglos -->
            <h4 style="font-size: 1rem; color: #0f172a; margin-bottom: 0.75rem;">Arreglos en este pedido:</h4>
            <?php foreach ($order['items'] as $item): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.65rem 0; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem;">
                    <div>
                        <strong><?= View::e($item['product_name']) ?></strong> x <?= $item['quantity'] ?>
                    </div>
                    <span style="font-weight: 700; color: var(--primary);">
                        <?= View::money($item['total_price']) ?>
                    </span>
                </div>
            <?php endforeach; ?>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; margin-top: 0.5rem; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                <span>Total:</span>
                <span style="color: var(--primary);"><?= View::money($order['total_amount']) ?></span>
            </div>
        </div>

        <!-- Botones de Acción -->
        <?php 
        $wspNum = $settings['site_whatsapp'] ?? '51932070468';
        $wspMsg = "¡Hola Florería Tulisol! Acabo de realizar el pedido #" . $order['order_code'] . " para " . $order['recipient_name'] . ". Quisiera consultar el estado del armado de las flores.";
        ?>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
            <a href="https://wa.me/<?= $wspNum ?>?text=<?= urlencode($wspMsg) ?>" target="_blank" class="btn btn-whatsapp">
                <?= View::icon('whatsapp', 18) ?> <span>Coordinar por WhatsApp</span>
            </a>
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">
                Volver a la Tienda
            </a>
        </div>
    </div>
</div>
