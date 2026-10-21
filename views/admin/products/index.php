<!-- ========================================================
     Listado de Productos / Ramos Florales - Florería Tulisol CMS
     ======================================================== -->

<div class="card">
    <div class="card-header">
        <div>
            <h3>Catálogo de Ramos y Arreglos Florales</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Todas las imágenes se almacenan estrictamente en formato <strong>WebP</strong> optimizado.</span>
        </div>
        <a href="<?= BASE_URL ?>admin/productos/crear" class="btn-admin btn-admin-primary">
            + Nuevo Arreglo Floral
        </a>
    </div>

    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Imagen</th>
                        <th>Nombre del Arreglo</th>
                        <th>Categoría</th>
                        <th>Precio Regular</th>
                        <th>Oferta</th>
                        <th>Stock</th>
                        <th>Destacado</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 2.5rem; color: #64748b;">
                                No hay arreglos florales registrados todavía.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $prod): ?>
                            <tr>
                                <td>
                                    <img src="<?= View::upload($prod['main_image']) ?>" alt="<?= View::e($prod['name']) ?>" class="table-thumb">
                                </td>
                                <td>
                                    <strong style="color: #0f172a; font-size: 0.95rem;"><?= View::e($prod['name']) ?></strong>
                                    <div style="font-size: 0.75rem; color: #64748b; font-family: monospace;">/producto/<?= View::e($prod['slug']) ?></div>
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.8rem; color: #475569;">
                                        <?= View::e($prod['category_name'] ?? 'Sin categoría') ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?= View::money($prod['price']) ?></strong>
                                </td>
                                <td>
                                    <?php if ($prod['sale_price']): ?>
                                        <span style="color: var(--admin-primary); font-weight: 700;">
                                            <?= View::money($prod['sale_price']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: <?= $prod['stock'] > 5 ? '#059669' : '#dc2626' ?>;">
                                        <?= $prod['stock'] ?> uds.
                                    </span>
                                </td>
                                <td>
                                    <?php if ($prod['is_featured']): ?>
                                        <span style="color: var(--primary-dark, #9e5365); font-weight: 600; font-size: 0.85rem;">Destacado</span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?= BASE_URL ?>admin/productos/toggle/<?= $prod['id'] ?>" method="POST" style="display: inline;">
                                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                                            <span class="badge <?= $prod['is_active'] ? 'badge-delivered' : 'badge-cancelled' ?>">
                                                <?= $prod['is_active'] ? 'Activo' : 'Inactivo' ?>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <a href="<?= BASE_URL ?>producto/<?= urlencode($prod['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="padding: 0.35rem 0.65rem;" title="Ver en tienda">
                                            <?= View::icon('eye', 15) ?>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/productos/editar/<?= $prod['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 0.35rem 0.65rem;" title="Editar">
                                            <?= View::icon('edit', 15) ?>
                                        </a>
                                        <form action="<?= BASE_URL ?>admin/productos/eliminar/<?= $prod['id'] ?>" method="POST" style="display: inline;">
                                            <button type="submit" class="btn-admin btn-admin-danger btn-confirm-delete" data-name="<?= View::e($prod['name']) ?>" style="padding: 0.35rem 0.65rem;" title="Eliminar">
                                                <?= View::icon('trash', 15) ?>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
