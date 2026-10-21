<!-- ========================================================
     Página de Inicio - Florería Tulisol
     ======================================================== -->

<div class="home-first-block">

<!-- 1. Hero Banner Principal -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-text-col">
            <span class="hero-subtitle">
                Floristería Boutique y Diseños de Autor
            </span>
            <h1 class="hero-title">
                Expresa tus <span>emociones</span> con flores frescas de exportación
            </h1>
            <p class="hero-description">
                <?= View::e($settings['about_subtitle'] ?? 'Diseños florales inolvidables para cumpleaños, aniversarios, reconciliaciones y momentos que perduran para siempre.') ?>
            </p>
            <div class="hero-buttons">
                <a href="<?= BASE_URL ?>catalogo" class="btn btn-primary">
                    Explorar Catálogo
                </a>
                <?php 
                $wspNum = $settings['site_whatsapp'] ?? '51932070468';
                ?>
                <a href="https://wa.me/<?= $wspNum ?>?text=<?= urlencode('¡Hola! Me gustaría cotizar un ramo floral personalizado.') ?>" target="_blank" class="btn btn-whatsapp">
                    <?= View::icon('whatsapp', 18) ?> <span>Pedir por WhatsApp</span>
                </a>
            </div>

            <!-- Mini Beneficios -->
            <div class="hero-features">
                <div class="feature-mini">
                    <div class="feature-mini-icon"><?= View::icon('truck', 18) ?></div>
                    <div class="feature-mini-text">
                        <h5>Entrega el mismo día</h5>
                        <p>Envíos express en toda la ciudad</p>
                    </div>
                </div>
                <div class="feature-mini">
                    <div class="feature-mini-icon"><?= View::icon('mail', 18) ?></div>
                    <div class="feature-mini-text">
                        <h5>Tarjeta de Dedicatoria</h5>
                        <p>Incluye sobre lacrado sin costo</p>
                    </div>
                </div>
                <div class="feature-mini">
                    <div class="feature-mini-icon"><?= View::icon('card', 18) ?></div>
                    <div class="feature-mini-text">
                        <h5>Culqi / Yape / Plin</h5>
                        <p>Pagos seguros y rápidos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-img-card">
                <img src="<?= View::upload('uploads/products/bouquet-palo-rosa.webp') ?>" alt="Bouquet Palo Rosa y Rosas Nude" loading="eager">
                <div class="hero-floating-badge">
                    <div class="badge-avatar-group">
                        <span style="letter-spacing:2px; font-size:0.9rem; color:var(--primary-dark);">CALIDAD PREMIUM</span>
                    </div>
                    <div>
                        <p>Diseño Floral de Autor</p>
                        <span>Paleta Palo Rosa y Tonos Marfil</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Categorías representativas (imagen del producto más destacado) -->
<section class="categories-section">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Explora por Categoría</span>
            <h2 class="section-heading">Nuestras Categorías</h2>
            <p class="section-desc">Cada categoría con su arreglo más destacado</p>
        </div>

        <div class="categories-grid">
            <?php foreach ($categories as $cat): ?>
                <?php
                $catImg = $cat['featured_image'] ?? $cat['image'] ?? 'uploads/categories/cat-bouquets.webp';
                ?>
                <a href="<?= BASE_URL ?>catalogo?categoria=<?= urlencode($cat['slug']) ?>" class="cat-card">
                    <div class="cat-image-container">
                        <img src="<?= View::upload($catImg) ?>" alt="<?= View::e($cat['name']) ?>" class="cat-thumb-img" loading="lazy">
                        <?php if (!empty($cat['featured_product_name'])): ?>
                            <div class="cat-featured-label">
                                <?= View::icon('star', 12) ?> <span><?= View::e($cat['featured_product_name']) ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="cat-badge-overlay"><?= $cat['product_count'] ?? 0 ?> diseños</span>
                    </div>
                    <div class="cat-body">
                        <h4><?= View::e($cat['name']) ?></h4>
                        <?php if (!empty($cat['description'])): ?>
                            <p class="cat-desc-text"><?= View::e($cat['description']) ?></p>
                        <?php endif; ?>
                        <span class="cat-explore-link">Ver catálogo &rarr;</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</div><!-- /home-first-block -->

<!-- 3. Arreglos Florales Destacados -->
<section class="products-section">
    <div class="container">
        <div class="section-title-wrap">
            <span class="section-badge">Los Preferidos</span>
            <h2 class="section-heading">Arreglos Florales Más Populares</h2>
            <p class="section-desc">Elaborados con flores recién cosechadas y papel importado</p>
        </div>

        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">
                    <div class="product-thumb-wrap">
                        <?php if ($product['is_featured']): ?>
                            <span class="product-badge-float">Destacado</span>
                        <?php endif; ?>
                        <?php if ($product['sale_price']): ?>
                            <span class="product-badge-sale">Oferta</span>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>producto/<?= urlencode($product['slug']) ?>">
                            <img src="<?= View::upload($product['main_image']) ?>" alt="<?= View::e($product['name']) ?>" class="product-thumb-img" loading="lazy">
                        </a>
                    </div>

                    <div class="product-content">
                        <span class="product-category-tag"><?= View::e($product['category_name'] ?? 'Flores') ?></span>
                        <h3 class="product-title">
                            <a href="<?= BASE_URL ?>producto/<?= urlencode($product['slug']) ?>">
                                <?= View::e($product['name']) ?>
                            </a>
                        </h3>
                        <p class="product-desc-excerpt"><?= View::e($product['short_description'] ?? '') ?></p>

                        <div class="product-price-row">
                            <?php if ($product['sale_price']): ?>
                                <span class="price-current"><?= View::money($product['sale_price']) ?></span>
                                <span class="price-old"><?= View::money($product['price']) ?></span>
                            <?php else: ?>
                                <span class="price-current"><?= View::money($product['price']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="product-actions-row">
                            <button type="button" class="btn-add-cart btn-add-cart-action" data-product-id="<?= $product['id'] ?>">
                                <?= View::icon('cart', 16) ?> <span>Añadir al Carrito</span>
                            </button>
                            <a href="<?= BASE_URL ?>producto/<?= urlencode($product['slug']) ?>" class="btn-view-quick" title="Ver detalles y dedicatoria">
                                <?= View::icon('eye', 18) ?>
                            </a>
                            <a href="<?= WhatsAppHelper::productLink($product, $settings['site_whatsapp'] ?? null) ?>" class="btn-view-quick btn-wsp-buy" target="_blank" rel="noopener noreferrer" title="Comprar por WhatsApp">
                                <?= View::icon('whatsapp', 18) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="<?= BASE_URL ?>catalogo" class="btn btn-secondary">
                Ver Catálogo Completo (<?= count($featuredProducts) ?>+ Arreglos)
            </a>
        </div>
    </div>
</section>

<!-- 4. Sección de Beneficios / Valores de Marca -->
<section class="values-section">
    <div class="container">
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon-circle"><?= View::icon('sparkles', 22) ?></div>
                <h4>Flores de Exportación</h4>
                <p>Seleccionamos rosas y tulipanes de primera calidad cada madrugada garantizando frescura y durabilidad prolongada.</p>
            </div>
            <div class="value-card">
                <div class="value-icon-circle"><?= View::icon('mail', 22) ?></div>
                <h4>Dedicatoria Personalizada</h4>
                <p>Escribe tu mensaje especial en el checkout y lo imprimiremos en una tarjeta fina en sobre lacrado sin costo adicional.</p>
            </div>
            <div class="value-card">
                <div class="value-icon-circle"><?= View::icon('card', 22) ?></div>
                <h4>Pasarela Culqi Segura</h4>
                <p>Paga al instante con Visa, Mastercard, American Express o directamente con billeteras móviles como Yape y Plin.</p>
            </div>
            <div class="value-card">
                <div class="value-icon-circle"><?= View::icon('clock', 22) ?></div>
                <h4>Garantía de Puntualidad</h4>
                <p>Cumplimos con el turno de entrega seleccionado para que tu detalle llegue en el momento preciso.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. Reseña de la Empresa / Historia -->
<section style="padding: 5rem 0; background: #fff;">
    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div>
            <span class="section-badge">Florería Tulisol</span>
            <h2 class="section-heading"><?= View::e($settings['about_title'] ?? 'Creando momentos inolvidables') ?></h2>
            <p style="font-size: 1.05rem; color: #475569; line-height: 1.8; margin-bottom: 1.5rem;">
                <?= View::e($settings['about_text'] ?? 'En Florería Tulisol cultivamos el amor en cada detalle. Cada ramo es elaborado artesanalmente por floristas apasionados.') ?>
            </p>
            <p style="font-size: 0.95rem; color: #64748b; line-height: 1.7; margin-bottom: 2rem;">
                <strong>Misión:</strong> <?= View::e($settings['about_mission'] ?? 'Llevar alegría y cercanía a través de arreglos de categoría premium.') ?>
            </p>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="<?= BASE_URL ?>contacto" class="btn btn-primary">Visitar Nuestra Tienda</a>
                <span style="color: #64748b; font-size: 0.9rem; display:inline-flex; align-items:center; gap:0.35rem;"><?= View::icon('pin', 16) ?> <?= View::e($settings['site_address'] ?? 'Centro Histórico') ?></span>
            </div>
        </div>
        <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <img src="<?= View::upload('uploads/products/sombrerera-tulipanes.webp') ?>" alt="Florería Tulisol Taller Floral" style="width: 100%; height: 420px; object-fit: cover;">
        </div>
    </div>
</section>
