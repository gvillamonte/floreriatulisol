<!-- ========================================================
     Detalle de Arreglo Floral - Florería Tulisol
     ======================================================== -->

<div class="product-detail-section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 2rem;">
            <a href="<?= BASE_URL ?>">Inicio</a> / 
            <a href="<?= BASE_URL ?>catalogo">Catálogo</a> / 
            <?php if (!empty($product['category_name'])): ?>
                <a href="<?= BASE_URL ?>catalogo?categoria=<?= urlencode($product['category_slug'] ?? '') ?>"><?= View::e($product['category_name']) ?></a> / 
            <?php endif; ?>
            <span style="color: #0f172a; font-weight: 600;"><?= View::e($product['name']) ?></span>
        </div>

        <div class="product-detail-grid">
            <!-- Galería e Imagen Principal WebP -->
            <div>
                <div class="product-gallery-main">
                    <img src="<?= View::upload($product['main_image']) ?>" alt="<?= View::e($product['name']) ?>">
                </div>
                <div style="display: flex; gap: 0.5rem; margin-top: 1rem; align-items: center; justify-content: center; font-size: 0.8rem; color: #64748b;">
                    <span>Formato optimizado <strong>WebP</strong></span>
                    <span>•</span>
                    <span>Flores frescas de exportación</span>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="product-detail-info">
                <?php if ($product['is_featured']): ?>
                    <span class="product-detail-badge">Arreglo Floral de Autor</span>
                <?php endif; ?>

                <h1 class="product-detail-title"><?= View::e($product['name']) ?></h1>

                <div class="product-detail-price">
                    <?php if ($product['sale_price']): ?>
                        <span class="current"><?= View::money($product['sale_price']) ?></span>
                        <span class="old"><?= View::money($product['price']) ?></span>
                        <span style="background: var(--secondary-lighter); color: var(--secondary-dark); border: 1px solid var(--border-color); font-size: 0.8rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                            Ahorras <?= View::money($product['price'] - $product['sale_price']) ?>
                        </span>
                    <?php else: ?>
                        <span class="current"><?= View::money($product['price']) ?></span>
                    <?php endif; ?>
                </div>

                <p style="font-size: 1.05rem; color: #475569; line-height: 1.7; margin-bottom: 1.75rem;">
                    <?= nl2br(View::e($product['description'] ?: $product['short_description'])) ?>
                </p>

                <!-- Flores que incluye -->
                <?php if (!empty($product['flowers_included'])): ?>
                    <div class="detail-block" style="background: var(--primary-subtle); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color);">
                        <h4><span style="display:inline-flex; align-items:center;"><?= View::icon('sparkles', 16) ?></span> Flores y elementos que incluye:</h4>
                        <p style="font-size: 0.925rem; color: var(--text-main);"><?= nl2br(View::e($product['flowers_included'])) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Consejos de cuidado -->
                <?php if (!empty($product['care_tips'])): ?>
                    <div class="detail-block" style="background: var(--secondary-lighter); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--secondary-light);">
                        <h4 style="color: var(--secondary-dark);"><span style="display:inline-flex; align-items:center;"><?= View::icon('clock', 16) ?></span> Cuidados para prolongar su frescura:</h4>
                        <p style="font-size: 0.925rem; color: var(--secondary-dark);"><?= nl2br(View::e($product['care_tips'])) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Mensaje de Dedicatoria -->
                <div class="dedication-card-box">
                    <label for="product-dedication-note" style="display:flex; align-items:center; gap:0.4rem;">
                        <?= View::icon('mail', 16) ?> Tarjeta de dedicatoria de cortesía (Opcional):
                    </label>
                    <textarea id="product-dedication-note" class="dedication-textarea" rows="3" placeholder="Escribe tu mensaje personal para la tarjeta..."></textarea>
                    <small style="color: #6d544c; display: block; margin-top: 0.35rem; font-size: 0.78rem;">
                        Imprimiremos tu dedicatoria en una tarjeta fina dentro de un sobre lacrado.
                    </small>
                </div>

                <!-- Selector de Cantidad y Botones de Compra -->
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                    <div class="quantity-control">
                        <button type="button" class="qty-btn" id="qty-decrease">-</button>
                        <input type="text" id="product-detail-qty" value="1" readonly class="qty-input">
                        <button type="button" class="qty-btn" id="qty-increase">+</button>
                    </div>

                    <button type="button" class="btn btn-primary btn-add-cart-action" data-product-id="<?= $product['id'] ?>" style="flex-grow: 1; padding: 1rem;">
                        <?= View::icon('cart', 16) ?> <span>Añadir al Carrito</span>
                    </button>
                </div>

                <!-- Comprar por WhatsApp con todos los datos del producto -->
                <a href="<?= WhatsAppHelper::productLink($product, $settings['site_whatsapp'] ?? null) ?>"
                   class="btn btn-whatsapp btn-wsp-buy"
                   data-detail="1"
                   data-price-num="<?= (float) ($product['sale_price'] ?: $product['price']) ?>"
                   target="_blank" rel="noopener noreferrer"
                   style="width: 100%; justify-content: center; padding: 1rem; margin-bottom: 2rem; font-size: 1rem;">
                    <?= View::icon('whatsapp', 18) ?> <span>Comprar por WhatsApp</span>
                </a>

                <!-- Pagos con Culqi y Billeteras -->
                <div style="background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b; display: block; margin-bottom: 0.5rem;">
                        Aceptamos pagos seguros vía Culqi:
                    </span>
                    <div class="culqi-badge-strip">
                        <span class="wallet-badge badge-visa">VISA</span>
                        <span class="wallet-badge badge-master">Mastercard</span>
                        <span class="wallet-badge badge-yape">YAPE</span>
                        <span class="wallet-badge badge-plin">PLIN</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arreglos Relacionados -->
        <?php if (!empty($relatedProducts)): ?>
            <div style="margin-top: 5rem; padding-top: 3rem; border-top: 1px solid #e2e8f0;">
                <div class="section-title-wrap">
                    <span class="section-badge">Recomendados</span>
                    <h2 class="section-heading">También te podría encantar</h2>
                </div>
                <div class="products-grid">
                    <?php foreach ($relatedProducts as $rel): ?>
                        <div class="product-card">
                            <div class="product-thumb-wrap">
                                <a href="<?= BASE_URL ?>producto/<?= urlencode($rel['slug']) ?>">
                                    <img src="<?= View::upload($rel['main_image']) ?>" alt="<?= View::e($rel['name']) ?>" class="product-thumb-img">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title">
                                    <a href="<?= BASE_URL ?>producto/<?= urlencode($rel['slug']) ?>"><?= View::e($rel['name']) ?></a>
                                </h3>
                                <div class="product-price-row">
                                    <span class="price-current"><?= View::money($rel['price']) ?></span>
                                </div>
                                <div class="product-actions-row">
                                    <button type="button" class="btn-add-cart btn-add-cart-action" data-product-id="<?= $rel['id'] ?>">
                                        Añadir al Carrito
                                    </button>
                                    <a href="<?= WhatsAppHelper::productLink($rel, $settings['site_whatsapp'] ?? null) ?>" class="btn-view-quick btn-wsp-buy" target="_blank" rel="noopener noreferrer" title="Comprar por WhatsApp">
                                        <?= View::icon('whatsapp', 18) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
