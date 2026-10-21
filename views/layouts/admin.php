<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= View::e($pageTitle ?? 'Panel CMS | Florería Tulisol') ?></title>
    
    <!-- Favicon WebP -->
    <link rel="icon" type="image/webp" href="<?= View::upload($settings['site_favicon'] ?? 'uploads/branding/favicon.webp') ?>">

    <!-- Tipografía Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS del CMS -->
    <link rel="stylesheet" href="<?= View::asset('assets/css/admin.css') ?>">

    <script>
        window.BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>
<body>

    <!-- 1. Sidebar Administrativo (Acordeón dinámico) -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <span style="color: var(--admin-accent); display: flex; align-items: center;"><?= View::icon('flower', 26) ?></span>
            <div>
                <div class="sidebar-brand-name"><?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?></div>
                <span class="sidebar-brand-badge">Panel CMS</span>
            </div>
        </div>

        <?php
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';
        $menuGroups = AdminMenu::build($currentUri);
        ?>

        <nav class="sidebar-nav">
            <?php foreach ($menuGroups as $gKey => $group): ?>
                <div class="sidebar-group <?= $group['open'] ? 'is-open' : '' ?>" data-group="<?= View::e($gKey) ?>">
                    <button type="button" class="sidebar-group-toggle" aria-expanded="<?= $group['open'] ? 'true' : 'false' ?>">
                        <span class="sidebar-group-label"><?= View::e($group['label']) ?></span>
                        <svg class="sidebar-group-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="sidebar-group-body">
                        <?php foreach ($group['items'] as $item): ?>
                            <?php
                            $href = !empty($item['external'])
                                ? BASE_URL
                                : BASE_URL . ltrim($item['url'] ?? '', '/');
                            $target = !empty($item['external']) ? ' target="_blank" rel="noopener"' : '';
                            ?>
                            <a href="<?= $href ?>" class="sidebar-link <?= !empty($item['active']) ? 'active' : '' ?> <?= !empty($item['danger']) ? 'sidebar-link-danger' : '' ?>"<?= $target ?>>
                                <?= View::icon($item['icon'] ?? 'grid', 17) ?> <span><?= View::e($item['label']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-user-card">
                <div class="admin-avatar">
                    <?= strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="admin-user-info">
                    <h6><?= View::e($adminUser['name'] ?? 'Admin') ?></h6>
                    <span><?= View::e($adminUser['email'] ?? 'admin@floreriatulisol.com') ?></span>
                </div>
            </div>
        </div>
    </aside>

    <!-- 2. Área Principal de Trabajo -->
    <div class="admin-main">
        <!-- Barra Superior -->
        <header class="admin-topbar">
            <div class="topbar-title">
                <h2><?= View::e($pageTitle ?? 'Panel de Administración') ?></h2>
            </div>
            <div class="topbar-actions">
                <a href="<?= BASE_URL ?>" target="_blank" class="btn-admin btn-admin-secondary" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                    <?= View::icon('eye', 16) ?> <span>Previsualizar Web</span>
                </a>
                <a href="<?= BASE_URL ?>admin/productos/crear" class="btn-admin btn-admin-primary" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                    <?= View::icon('plus', 16) ?> <span>Nuevo Arreglo</span>
                </a>
            </div>
        </header>

        <!-- Contenido -->
        <main class="admin-content">
            <!-- Alertas Flash -->
            <?php if (Session::hasFlash('success')): ?>
                <div class="alert alert-success" style="display: flex; align-items: center; gap: 0.5rem;">
                    <?= View::icon('check', 18) ?> <span><?= Session::getFlash('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if (Session::hasFlash('error')): ?>
                <div class="alert alert-error" style="display: flex; align-items: center; gap: 0.5rem;">
                    <?= View::icon('alert', 18) ?> <span><?= Session::getFlash('error') ?></span>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>

    <!-- Scripts del CMS -->
    <script src="<?= View::asset('assets/js/admin.js') ?>"></script>
</body>
</html>
