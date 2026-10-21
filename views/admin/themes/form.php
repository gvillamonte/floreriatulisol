<!-- ========================================================
     Formulario Crear/Editar Tema de Color - Florería Tulisol CMS
     ======================================================== -->

<?php $isEdit = !empty($theme); ?>

<div class="card">
    <div class="card-header">
        <div>
            <h3><?= $isEdit ? 'Editar Tema' : 'Nuevo Tema de Color' ?></h3>
            <span style="font-size: 0.85rem; color: #64748b;">Elige la paleta y el rango de fechas en que la tienda cambiará de color.</span>
        </div>
        <a href="<?= BASE_URL ?>admin/temas" class="btn-admin btn-admin-secondary">
            ← Volver
        </a>
    </div>

    <div class="card-body">
        <form action="<?= $isEdit ? BASE_URL . 'admin/temas/' . $theme['id'] . '/actualizar' : BASE_URL . 'admin/temas/guardar' ?>" method="POST">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">Nombre del tema *</label>
                    <input type="text" name="name" required maxlength="80"
                           value="<?= View::e($theme['name'] ?? '') ?>"
                           placeholder="Ej: Día de la Madre - Amarillo"
                           style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">Orden de prioridad</label>
                    <input type="number" name="sort_order" min="0" max="999"
                           value="<?= View::e($theme['sort_order'] ?? '0') ?>"
                           style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">
                    <span style="font-size: 0.75rem; color: #64748b;">Si dos temas coinciden en fechas, gana el de menor número.</span>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.6rem; font-size: 0.9rem;">Paleta de color *</label>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <?php
                    $currentPalette = $theme['palette'] ?? '';
                    $paletteOptions = [
                        'yellow' => ['#d4a017', '#e8c14a', '#a67c00'],
                        'purple' => ['#7c5cbf', '#a184e0', '#5a3d96'],
                        'blue'   => ['#3b7dd8', '#6fa3e8', '#2a5fa8'],
                    ];
                    foreach ($paletteOptions as $key => $colors):
                        $checked = $currentPalette === $key ? 'checked' : '';
                    ?>
                        <label style="cursor: pointer; flex: 1; min-width: 160px;">
                            <input type="radio" name="palette" value="<?= $key ?>" <?= $checked ?> required style="display: none;" onchange="this.closest('label').style.outline = this.checked ? '2px solid #0f172a' : 'none';">
                            <div style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 1rem; text-align: center; transition: 0.2s; <?= $checked ? 'outline: 2px solid #0f172a;' : '' ?>">
                                <div style="display: flex; justify-content: center; gap: 6px; margin-bottom: 0.5rem;">
                                    <?php foreach ($colors as $c): ?>
                                        <span style="width: 28px; height: 28px; border-radius: 50%; background: <?= $c ?>; display: inline-block;"></span>
                                    <?php endforeach; ?>
                                </div>
                                <strong style="font-size: 0.9rem;"><?= View::e($labels[$key]) ?></strong>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">Fecha de inicio *</label>
                    <input type="date" name="start_date" required
                           value="<?= View::e($theme['start_date'] ?? '') ?>"
                           style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">Fecha de fin *</label>
                    <input type="date" name="end_date" required
                           value="<?= View::e($theme['end_date'] ?? '') ?>"
                           style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem;">
                </div>
            </div>

            <div style="margin-bottom: 1.75rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                    <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $theme['is_active']) ? 'checked' : '' ?>>
                    Tema activo (se aplica cuando la fecha esté dentro del rango)
                </label>
            </div>

            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn-admin btn-admin-primary">
                    <?= $isEdit ? 'Guardar Cambios' : 'Crear Tema' ?>
                </button>
                <a href="<?= BASE_URL ?>admin/temas" class="btn-admin btn-admin-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
