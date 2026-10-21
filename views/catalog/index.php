<!-- ========================================================
     Catálogo de Productos - Florería Tulisol
     ======================================================== -->

<div class="catalog-page-header">
    <div class="container">
        <span class="section-badge">Catálogo Exclusivo</span>
        <h1 style="font-size: 2.75rem; color: var(--text-main); margin-bottom: 0.5rem;">
            <?= $selectedCategory ? View::e($selectedCategory['name']) : 'Nuestros Arreglos Florales' ?>
        </h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto;">
            <?= $selectedCategory ? View::e($selectedCategory['description'] ?? '') : 'Descubre ramos únicos, arreglos en sombrereras, jarrones y cajas de autor diseñadas con amor en tonos palo rosa y marfil.' ?>
        </p>
    </div>
</div>

<div class="container" style="padding: 3.5rem 1.25rem 5rem;">
    <!-- Barra de Filtros y Búsqueda -->
    <div class="catalog-filter-bar">
        <!-- Píldoras de Categorías -->
        <div class="category-pills">
            <a href="<?= BASE_URL ?>catalogo" class="cat-pill <?= empty($selectedCategory) ? 'active' : '' ?>">
                Todas las Flores (<?= $total ?>)
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= BASE_URL ?>catalogo?categoria=<?= urlencode($cat['slug']) ?>" class="cat-pill <?= ($selectedCategory && $selectedCategory['slug'] === $cat['slug']) ? 'active' : '' ?>">
                    <?= View::e($cat['name']) ?> (<?= $cat['product_count'] ?? 0 ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Buscador y Orden -->
        <form method="GET" action="<?= BASE_URL ?>catalogo" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <?php if ($selectedCategory): ?>
                <input type="hidden" name="categoria" value="<?= View::e($selectedCategory['slug']) ?>">
            <?php endif; ?>

            <input type="text" name="q" value="<?= View::e($searchQuery ?? '') ?>" placeholder="Buscar flores, rosas..." class="form-control" style="width: 200px; padding: 0.5rem 0.85rem; font-size: 0.85rem;">

            <select name="orden" onchange="this.form.submit()" class="sort-select">
                <option value="default" <?= ($currentSort === 'default') ? 'selected' : '' ?>>Ordenar por: Destacados</option>
                <option value="price_asc" <?= ($currentSort === 'price_asc') ? 'selected' : '' ?>>Precio: Menor a Mayor</option>
                <option value="price_desc" <?= ($currentSort === 'price_desc') ? 'selected' : '' ?>>Precio: Mayor a Menor</option>
                <option value="popular" <?= ($currentSort === 'popular') ? 'selected' : '' ?>>Más Vendidos</option>
            </select>
            
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.55rem 0.85rem;">Filtrar</button>
        </form>
    </div>

    <!-- Grid de Productos -->
    <?php if (empty($products)): ?>
        <div style="text-align: center; padding: 4rem 1rem; background: #fff; border-radius: 16px; border: 1px dashed var(--border-color);">
            <div style="color: var(--primary-light); margin-bottom: 1rem;"><?= View::icon('search', 42) ?></div>
            <h3 style="font-size: 1.35rem; color: var(--text-main); margin-bottom: 0.5rem;">No encontramos arreglos con estos criterios</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Prueba buscando otra palabra clave o navegando en otra categoría floral.</p>
            <a href="<?= BASE_URL ?>catalogo" class="btn btn-primary">Ver Todos los Arreglos</a>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
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
    <?php endif; ?>
</div>
