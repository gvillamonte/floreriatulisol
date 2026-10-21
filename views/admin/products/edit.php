<!-- ========================================================
     Editar Arreglo Floral - Florería Tulisol CMS
     ======================================================== -->

<div class="card" style="max-width: 900px; margin: 0 auto 2rem;">
    <div class="card-header">
        <h3>Editar: <?= View::e($product['name']) ?></h3>
        <a href="<?= BASE_URL ?>admin/productos" class="btn-admin btn-admin-secondary" style="display: inline-flex; align-items: center; gap: 0.4rem;">
            <?= View::icon('arrow-left', 14) ?> Volver al Listado
        </a>
    </div>

    <div class="card-body">
        <form action="<?= BASE_URL ?>admin/productos/actualizar/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">

            <div class="form-section">
                <div class="form-section-title">Información básica</div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre del arreglo floral *</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= View::e($product['name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">Categoría</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= View::e($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="color_theme">Color del arreglo</label>
                    <select id="color_theme" name="color_theme" class="form-control">
                        <option value="none" <?= ($product['color_theme'] ?? 'none') === 'none' ? 'selected' : '' ?>>Sin color asignado</option>
                        <option value="yellow" <?= ($product['color_theme'] ?? '') === 'yellow' ? 'selected' : '' ?>>Amarillo (flores amarillas)</option>
                        <option value="purple" <?= ($product['color_theme'] ?? '') === 'purple' ? 'selected' : '' ?>>Morado (flores moradas)</option>
                        <option value="blue" <?= ($product['color_theme'] ?? '') === 'blue' ? 'selected' : '' ?>>Azul (flores azules)</option>
                    </select>
                    <small class="form-hint">Se mostrará primero cuando el tema de color de esta paleta esté activo por fecha.</small>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Precios y stock</div>

                <div class="form-row-3">
                    <div class="form-group">
                        <label class="form-label" for="price">Precio regular (S/.) *</label>
                        <input type="number" step="0.50" id="price" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sale_price">Precio de oferta (opcional)</label>
                        <input type="number" step="0.50" id="sale_price" name="sale_price" class="form-control" value="<?= $product['sale_price'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="stock">Stock disponible</label>
                        <input type="number" id="stock" name="stock" class="form-control" value="<?= $product['stock'] ?>" min="0">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Fotografía principal</div>

                <div class="product-image-current">
                    <img src="<?= View::upload($product['main_image']) ?>" alt="Foto actual">
                    <div>
                        <span class="form-hint" style="margin: 0 0 0.35rem;">Imagen actual en uso</span>
                        <strong style="font-size: 0.875rem; color: var(--admin-text-main); display: block; margin-bottom: 0.25rem;"><?= View::e($product['main_image']) ?></strong>
                        <p style="font-size: 0.8rem; color: var(--admin-text-muted);">Si deseas reemplazarla, selecciona un nuevo archivo abajo. Se convertirá y optimizará a WebP automáticamente.</p>
                    </div>
                </div>

                <div class="webp-upload-card" onclick="document.getElementById('edit_image_input').click()">
                    <div style="margin-bottom: 0.5rem; color: var(--admin-primary);"><?= View::icon('refresh', 32) ?></div>
                    <h5 style="color: #0f172a; margin-bottom: 0.2rem;">Haz clic para cambiar la fotografía</h5>
                    <p style="color: #64748b; font-size: 0.8rem;">Formatos aceptados: WebP, JPG, PNG (se convertirá a .webp)</p>

                    <input type="file" id="edit_image_input" name="main_image" class="webp-file-input" data-preview-target="edit-image-preview" data-notice-target="edit-image-notice" accept="image/webp,image/jpeg,image/png" style="display: none;">

                    <div id="edit-image-preview" class="preview-container">
                        <img src="" alt="Nueva previsualización">
                    </div>
                    <div id="edit-image-notice" style="display: none; font-size: 0.85rem; color: #059669; margin-top: 0.75rem; font-weight: 600;"></div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Descripciones</div>

                <div class="form-group">
                    <label class="form-label" for="short_description">Descripción breve (para tarjetas y catálogo)</label>
                    <input type="text" id="short_description" name="short_description" class="form-control" value="<?= View::e($product['short_description'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Descripción completa del arreglo</label>
                    <textarea id="description" name="description" class="form-control" rows="4"><?= View::e($product['description'] ?? '') ?></textarea>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="flowers_included">Flores y follaje que contiene</label>
                        <textarea id="flowers_included" name="flowers_included" class="form-control" rows="3"><?= View::e($product['flowers_included'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="care_tips">Consejos de cuidado del florista</label>
                        <textarea id="care_tips" name="care_tips" class="form-control" rows="3"><?= View::e($product['care_tips'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Opciones de publicación</div>

                <div class="form-check-row">
                    <label class="form-check">
                        <input type="checkbox" name="is_featured" value="1" <?= $product['is_featured'] ? 'checked' : '' ?>>
                        Destacar en portada
                    </label>

                    <label class="form-check">
                        <input type="checkbox" name="is_best_seller" value="1" <?= $product['is_best_seller'] ? 'checked' : '' ?>>
                        Marcar como más vendido
                    </label>

                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $product['is_active'] ? 'checked' : '' ?>>
                        Visible en la tienda (activo)
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 0.5rem;">
                <a href="<?= BASE_URL ?>admin/productos" class="btn-admin btn-admin-secondary">Cancelar</a>
                <button type="submit" class="btn-admin btn-admin-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
