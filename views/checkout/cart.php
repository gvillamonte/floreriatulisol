<!-- ========================================================
     Vista de Carrito - Florería Tulisol
     ======================================================== -->

<div class="container" style="padding: 4rem 1.25rem 6rem;">
    <div class="section-title-wrap" style="text-align: left; margin-bottom: 2rem;">
        <span class="section-badge">Tu Selección</span>
        <h1 class="section-heading">Carrito de Compras</h1>
    </div>

    <?php if (empty($cart)): ?>
        <div style="text-align: center; padding: 4rem 1rem; background: #fff; border-radius: 16px; border: 1px dashed var(--border-color);">
            <div style="color: var(--primary-light); margin-bottom: 1rem;"><?= View::icon('bag', 42) ?></div>
            <h3 style="font-size: 1.35rem; color: var(--text-main); margin-bottom: 0.5rem;">Tu carrito está vacío</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Añade arreglos florales o ramos exclusivos para continuar.</p>
            <a href="<?= BASE_URL ?>catalogo" class="btn btn-primary">Ver Catálogo de Ramos</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1.4fr 0.8fr; gap: 3rem; align-items: start;">
            <!-- Lista de Productos en el Carrito -->
            <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                <?php foreach ($cart as $item): ?>
                    <div style="display: grid; grid-template-columns: 80px 1fr auto auto; gap: 1.5rem; align-items: center; padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid #f1f5f9;">
                        <img src="<?= View::upload($item['image']) ?>" alt="<?= View::e($item['name']) ?>" style="width: 80px; height: 80px; border-radius: 10px; object-fit: cover;">
                        
                        <div>
                            <h4 style="font-size: 1.05rem; color: var(--text-main); margin-bottom: 0.25rem;">
                                <?= View::e($item['name']) ?>
                            </h4>
                            <span style="font-size: 0.9rem; font-weight: 700; color: var(--primary-dark);">
                                <?= View::money($item['price']) ?>
                            </span>
                            <?php if (!empty($item['dedication'])): ?>
                                <small style="display: flex; align-items: center; gap: 0.35rem; color: #6d544c; margin-top: 0.25rem; font-size: 0.8rem;">
                                    <?= View::icon('mail', 14) ?> Dedicatoria: "<?= View::e($item['dedication']) ?>"
                                </small>
                            <?php endif; ?>
                        </div>

                        <div>
                            <span style="font-size: 0.95rem; font-weight: 600; color: #475569;">
                                Cantidad: <?= $item['quantity'] ?>
                            </span>
                        </div>

                        <div>
                            <button type="button" onclick="removeCartItem(<?= $item['product_id'] ?>); setTimeout(() => location.reload(), 300);" style="background: none; border: none; color: #c56565; cursor: pointer; display: flex; align-items: center;" title="Eliminar del carrito">
                                <?= View::icon('trash', 18) ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <a href="<?= BASE_URL ?>catalogo" style="color: var(--primary); font-weight: 600; font-size: 0.9rem;">
                        ← Seguir agregando más flores
                    </a>
                </div>
            </div>

            <!-- Resumen de Costos -->
            <div style="background: #fff; border-radius: 16px; padding: 2rem; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1.25rem; color: #0f172a; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9;">
                    Resumen del Pedido
                </h3>

                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem; color: #475569;">
                    <span>Subtotal:</span>
                    <strong style="color: #0f172a;"><?= View::money($subtotal) ?></strong>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1.25rem; font-size: 0.95rem; color: #475569;">
                    <span>Costo de Envío / Delivery:</span>
                    <strong style="color: #0f172a;"><?= View::money($deliveryCost) ?></strong>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; padding-top: 1rem; border-top: 2px solid #e2e8f0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">
                    <span>Total a Pagar:</span>
                    <span style="color: var(--primary);"><?= View::money($total) ?></span>
                </div>

                <a href="<?= BASE_URL ?>checkout" class="btn btn-primary" style="width: 100%; text-align: center; padding: 1rem;">
                    Continuar al Checkout Seguro
                </a>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <span style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 0.5rem;">
                        Aceptamos pagos seguros vía Culqi:
                    </span>
                    <div class="culqi-badge-strip" style="justify-content: center;">
                        <span class="wallet-badge badge-visa">VISA</span>
                        <span class="wallet-badge badge-master">Mastercard</span>
                        <span class="wallet-badge badge-yape">YAPE</span>
                        <span class="wallet-badge badge-plin">PLIN</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
