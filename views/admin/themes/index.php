<!-- ========================================================
     Listado de Temas de Color por Fecha - Florería Tulisol CMS
     ======================================================== -->

<div class="card">
    <div class="card-header">
        <div>
            <h3>Temas de Color por Fecha</h3>
            <span style="font-size: 0.85rem; color: #64748b;">La tienda se tiñe automáticamente con el color del tema activo según la fecha.</span>
        </div>
        <a href="<?= BASE_URL ?>admin/temas/crear" class="btn-admin btn-admin-primary">
            + Nuevo Tema
        </a>
    </div>

    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Paleta</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($themes)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2.5rem; color: #64748b;">
                                No hay temas de color creados todavía.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($themes as $theme): ?>
                            <?php $status = ColorTheme::statusOf($theme); ?>
                            <tr>
                                <td>
                                    <strong style="color: #0f172a;"><?= View::e($theme['name']) ?></strong>
                                </td>
                                <td>
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; background: #f1f5f9; padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.8rem; color: #475569;">
                                        <span style="width: 12px; height: 12px; border-radius: 50%; background: <?= ThemeHelper::swatch($theme['palette']) ?>; display: inline-block;"></span>
                                        <?= View::e($labels[$theme['palette']] ?? $theme['palette']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($theme['start_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($theme['end_date'])) ?></td>
                                <td>
                                    <?php
                                    $statusConfig = [
                                        'active_today' => ['Activo hoy', '#059669', '#ecfdf5'],
                                        'scheduled'    => ['Programado', '#1d4ed8', '#eff6ff'],
                                        'expired'      => ['Expirado', '#6b7280', '#f3f4f6'],
                                        'inactive'     => ['Inactivo', '#991b1b', '#fee2e2'],
                                    ];
                                    [$label, $color, $bg] = $statusConfig[$status];
                                    ?>
                                    <span style="background: <?= $bg ?>; color: <?= $color ?>; padding: 0.25rem 0.6rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">
                                        <?= $label ?>
                                    </span>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <a href="<?= BASE_URL ?>admin/temas/<?= $theme['id'] ?>/editar" class="btn-admin btn-admin-secondary" style="padding: 0.35rem 0.7rem; font-size: 0.8rem;">
                                        Editar
                                    </a>
                                    <form action="<?= BASE_URL ?>admin/temas/<?= $theme['id'] ?>/eliminar" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar el tema &quot;<?= View::e($theme['name']) ?>&quot;?');">
                                        <button type="submit" class="btn-admin" style="background: #fee2e2; color: #991b1b; padding: 0.35rem 0.7rem; font-size: 0.8rem; border: none; cursor: pointer; border-radius: 8px;">
                                            Eliminar
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
