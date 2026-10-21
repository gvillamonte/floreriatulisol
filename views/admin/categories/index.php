<!-- ========================================================
     Gestión de Categorías - Florería Tulisol CMS
     ======================================================== -->

<?php
$editing = null;
if (!empty($_GET['editar'])) {
    foreach ($categories as $c) {
        if ((int)$c['id'] === (int)$_GET['editar']) {
            $editing = $c;
            break;
        }
    }
}
?>

<div style="display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 2rem; align-items: start;">
    <!-- Formulario Crear / Editar Categoría -->
    <div class="card">
        <div class="card-header">
            <h3><?= $editing ? 'Editar Categoría' : 'Nueva Categoría' ?></h3>
        </div>
        <div class="card-body">
            <form action="<?= $editing ? BASE_URL . 'admin/categorias/actualizar/' . $editing['id'] : BASE_URL . 'admin/categorias/guardar' ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="cat_name">Nombre de la Categoría *</label>
                    <input type="text" id="cat_name" name="name" class="form-control" placeholder="Ej: Colección Peluches" value="<?= View::e($editing['name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cat_desc">Descripción</label>
                    <textarea id="cat_desc" name="description" class="form-control" rows="3" placeholder="Breve descripción para el catálogo..."><?= View::e($editing['description'] ?? '') ?></textarea>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="cat_icon">Icono</label>
                        <select id="cat_icon" name="icon" class="form-control">
                            <?php
                            $iconOptions = [
                                'grid'      => 'Todos / General (cuadrícula)',
                                'bouquet'   => 'Ramo de flores',
                                'gift'      => 'Regalo / Caja',
                                'sparkles'  => 'Destellos / Especial',
                                'crown'     => 'Corona / Lujo',
                                'sun'       => 'Sol / Canasta silvestre',
                                'dove'      => 'Paloma / Condolencias',
                                'heart'     => 'Corazón / Amor',
                                'balloon'   => 'Globo',
                                'star'      => 'Estrella',
                                'flower'    => 'Flor',
                                'package'   => 'Paquete / Caja',
                            ];
                            $currentIcon = $editing['icon'] ?? 'sparkles';
                            foreach ($iconOptions as $val => $label):
                            ?>
                                <option value="<?= $val ?>" <?= $currentIcon === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Orden de Aparición</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= View::e($editing['sort_order'] ?? '0') ?>">
                    </div>
                </div>

                <!-- Foto de Categoría WebP -->
                <div class="form-group">
                    <label class="form-label">Foto / Portada (Se optimiza a WebP)</label>
                    <?php if (!empty($editing['image'])): ?>
                        <div style="margin-bottom: 0.6rem;">
                            <img src="<?= View::upload($editing['image']) ?>" alt="Imagen actual" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border-color);">
                            <span style="font-size: 0.75rem; color: #64748b; margin-left: 0.5rem;">Imagen actual</span>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/webp,image/jpeg,image/png">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editing || $editing['is_active']) ? 'checked' : '' ?>>
                        Categoría Activa en la Tienda
                    </label>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-admin btn-admin-primary" style="flex: 1;">
                        <?= $editing ? 'Guardar Cambios' : 'Crear Categoría' ?>
                    </button>
                    <?php if ($editing): ?>
                        <a href="<?= BASE_URL ?>admin/categorias" class="btn-admin btn-admin-secondary">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de Categorías Existentes -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Categorías Registradas</h3>
                <span style="font-size: 0.8rem; color: #64748b;">Usa las flechas para cambiar el orden en el menú de la tienda.</span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Orden</th>
                            <th>Categoría</th>
                            <th>Icono</th>
                            <th>Arreglos</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem; color: #64748b;">
                                    No hay categorías registradas todavía.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $idx => $c): ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.25rem;">
                                            <form action="<?= BASE_URL ?>admin/categorias/orden/<?= $c['id'] ?>" method="POST" style="display: inline;">
                                                <input type="hidden" name="direction" value="up">
                                                <button type="submit" class="btn-admin" <?= $idx === 0 ? 'disabled style="opacity:0.35; cursor:not-allowed;"' : 'style="padding: 0.2rem 0.4rem;"' ?> title="Subir">
                                                    <?= View::icon('arrow-up', 13) ?>
                                                </button>
                                            </form>
                                            <span style="font-weight: 700; min-width: 20px; text-align: center;"><?= $c['sort_order'] ?></span>
                                            <form action="<?= BASE_URL ?>admin/categorias/orden/<?= $c['id'] ?>" method="POST" style="display: inline;">
                                                <input type="hidden" name="direction" value="down">
                                                <button type="submit" class="btn-admin" <?= $idx === count($categories) - 1 ? 'disabled style="opacity:0.35; cursor:not-allowed;"' : 'style="padding: 0.2rem 0.4rem;"' ?> title="Bajar">
                                                    <?= View::icon('arrow-down', 13) ?>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a;"><?= View::e($c['name']) ?></strong>
                                        <?php if (!empty($c['description'])): ?>
                                            <div style="font-size: 0.75rem; color: #64748b;"><?= View::e(substr($c['description'], 0, 40)) ?>...</div>
                                        <?php endif; ?>
                                        <code style="background: #f1f5f9; padding: 0.1rem 0.35rem; border-radius: 4px; font-size: 0.7rem;"><?= View::e($c['slug']) ?></code>
                                    </td>
                                    <td>
                                        <?php $iconHtml = View::icon($c['icon'] ?? 'sparkles', 18); ?>
                                        <?php if ($iconHtml): ?>
                                            <span style="color: var(--admin-primary);"><?= $iconHtml ?></span>
                                        <?php else: ?>
                                            <span style="color: #94a3b8;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: var(--admin-primary);"><?= $c['product_count'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $c['is_active'] ? 'badge-delivered' : 'badge-cancelled' ?>">
                                            <?= $c['is_active'] ? 'Activa' : 'Inactiva' ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right; white-space: nowrap;">
                                        <a href="<?= BASE_URL ?>admin/categorias?editar=<?= $c['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 0.35rem 0.6rem;" title="Editar">
                                            <?= View::icon('edit', 14) ?>
                                        </a>
                                        <form action="<?= BASE_URL ?>admin/categorias/eliminar/<?= $c['id'] ?>" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar la categoría &quot;<?= View::e($c['name']) ?>&quot;?');">
                                            <button type="submit" class="btn-admin btn-admin-danger" style="padding: 0.35rem 0.6rem;" title="Eliminar">
                                                <?= View::icon('trash', 14) ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
