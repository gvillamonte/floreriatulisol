<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= View::e($pageTitle ?? ($settings['site_name'] ?? 'Florería Tulisol')) ?></title>
    
    <!-- Favicon en formato WebP -->
    <link rel="icon" type="image/webp" href="<?= View::upload($settings['site_favicon'] ?? 'uploads/branding/favicon.webp') ?>">

    <!-- Tipografías de Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">

    <!-- CSS del Frontend -->
    <link rel="stylesheet" href="<?= View::asset('assets/css/style.css') ?>">

    <?php if (!empty($activeTheme)): ?>
    <!-- Tema de color activo por fecha: <?= View::e($activeTheme['name']) ?> -->
    <style>
<?= ThemeHelper::cssVariables($activeTheme['palette']) ?>
    </style>
    <?php endif; ?>

    <!-- Culqi Checkout v4 JS -->
    <script src="https://checkout.culqi.com/js/v4"></script>

    <script>
        window.BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>
<body>

    <!-- 1. Barra Superior de Anuncios -->
    <div class="top-announcement">
        <span><strong>Entrega en 1 hora en todo Cusco:</strong> Wanchaq, Centro Histórico, San Sebastián, San Jerónimo y alrededores.</span>
    </div>

    <!-- 2. Header Principal -->
    <header class="header-main">
        <div class="container nav-container">
            <!-- Logo de la Empresa -->
            <a href="<?= BASE_URL ?>" class="brand-logo-link">
                <?php $logoUrl = View::upload($settings['site_logo'] ?? 'uploads/branding/logo.webp'); ?>
                <img src="<?= $logoUrl ?>" alt="<?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?>" class="brand-logo-img">
                <div>
                    <span class="brand-name"><?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?></span>
                    <span class="brand-tagline-nav"><?= View::e($settings['site_tagline'] ?? 'Detalles que florecen') ?></span>
                </div>
            </a>

            <!-- Buscador Central -->
            <form action="<?= BASE_URL ?>catalogo" method="GET" class="header-search">
                <span class="header-search-icon-left"><?= View::icon('search', 16) ?></span>
                <input type="search" name="q" value="<?= View::e($_GET['q'] ?? '') ?>" placeholder="¿Qué flores o detalle buscas hoy? (ej. rosas, peluche, tulipanes...)" aria-label="Buscar productos">
                <button type="submit" class="header-search-btn" aria-label="Buscar"><?= View::icon('search', 17) ?></button>
            </form>

            <!-- Acciones (WhatsApp + Carrito) -->
            <div class="nav-actions">
                <?php
                $wspRaw = $settings['site_whatsapp'] ?? '51932070468';
                $wspDisplay = $wspRaw;
                if (strlen($wspRaw) === 11 && str_starts_with($wspRaw, '51')) {
                    $wspDisplay = substr($wspRaw, 2);
                }
                $wspDisplay = trim(chunk_split($wspDisplay, 3, ' '));
                ?>
                <a href="https://wa.me/<?= View::e($wspRaw) ?>?text=<?= urlencode($settings['site_whatsapp_msg'] ?? '¡Hola Florería Tulisol! Quisiera información sobre un arreglo floral.') ?>" target="_blank" rel="noopener noreferrer" class="header-whatsapp-btn" title="Escríbenos por WhatsApp">
                    <?= View::icon('whatsapp', 17) ?> <span><?= View::e($wspDisplay) ?></span>
                </a>

                <button type="button" class="cart-btn-trigger" title="Ver carrito de compras">
                    <?= View::icon('cart', 20) ?>
                    <span class="cart-badge" style="<?= ($cartCount ?? 0) > 0 ? '' : 'display:none;' ?>"><?= $cartCount ?? 0 ?></span>
                </button>

                <!-- Botón Hamburguesa Móvil -->
                <button type="button" class="mobile-menu-toggle" aria-label="Abrir menú">
                    <?= View::icon('menu', 22) ?>
                </button>
            </div>
        </div>

        <!-- Menú Móvil (Inicio / Catálogo / Contacto) -->
        <nav class="mobile-nav-menu">
            <ul>
                <li><a href="<?= BASE_URL ?>" class="nav-link">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>catalogo" class="nav-link">Catálogo de Ramos</a></li>
                <li><a href="<?= BASE_URL ?>contacto" class="nav-link">Contacto y Tienda</a></li>
            </ul>
        </nav>

        <!-- Barra de Categorías (píldoras navegables) -->
        <nav class="category-nav">
            <div class="category-nav-scroll">
                <?php
                $currentCat = $_GET['categoria'] ?? '';
                ?>
                <a href="<?= BASE_URL ?>catalogo" class="cat-pill <?= $currentCat === '' ? 'active' : '' ?>">
                    <?= View::icon('grid', 14) ?> <span>Todos</span>
                </a>
                <?php foreach (($navCategories ?? []) as $cat): ?>
                    <a href="<?= BASE_URL ?>catalogo?categoria=<?= View::e($cat['slug']) ?>" class="cat-pill <?= $currentCat === $cat['slug'] ? 'active' : '' ?>">
                        <?php if (!empty($cat['icon'])): ?><?= View::icon($cat['icon'], 14) ?><?php endif; ?>
                        <span><?= View::e($cat['name']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
    </header>

    <!-- 3. Mensajes Flash Notificaciones -->
    <?php if (Session::hasFlash('success')): ?>
        <div class="container" style="margin-top: 1.5rem;">
            <div style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <?= View::icon('check', 18) ?> <span><?= Session::getFlash('success') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (Session::hasFlash('error')): ?>
        <div class="container" style="margin-top: 1.5rem;">
            <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <?= View::icon('alert', 18) ?> <span><?= Session::getFlash('error') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- 4. Contenido Dinámico de la Vista -->
    <main>
        <?= $content ?>
    </main>

    <!-- 5. Carrito Lateral (Drawer) -->
    <div class="cart-drawer-overlay"></div>
    <aside class="cart-drawer">
        <div class="drawer-header">
            <h3>Tu Carrito de Compras</h3>
            <button type="button" class="drawer-close-btn" aria-label="Cerrar carrito"><?= View::icon('close', 20) ?></button>
        </div>
        <div class="drawer-body" id="drawer-items-list">
            <!-- Se carga dinámicamente con app.js -->
            <p style="text-align: center; color: #94a3b8; padding: 2rem 0;">Cargando productos...</p>
        </div>
        <div class="drawer-footer">
            <div class="drawer-total-row">
                <span>Subtotal:</span>
                <span id="drawer-subtotal">S/ 0.00</span>
            </div>
            <a href="<?= BASE_URL ?>checkout" class="btn btn-primary" style="width: 100%; text-align: center;">
                Finalizar Compra Segura
            </a>
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 0.85rem; font-size: 0.75rem; color: #64748b;">
                <span>Pasarela Culqi Segura</span>
                <span>•</span>
                <span>Tarjetas y Billeteras Digitales</span>
            </div>
        </div>
    </aside>

    <!-- 6. Botón Flotante WhatsApp -->
    <?php 
    $wspNumber = $settings['site_whatsapp'] ?? '51932070468';
    $wspMsg = urlencode($settings['site_whatsapp_msg'] ?? '¡Hola Florería Tulisol! Quisiera información sobre un arreglo floral.');
    ?>
    <a href="https://wa.me/<?= $wspNumber ?>?text=<?= $wspMsg ?>" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Escríbenos por WhatsApp">
        <?= View::icon('whatsapp', 28) ?>
    </a>

    <!-- 7. Footer Principal -->
    <footer class="footer-main">
        <div class="container footer-grid">
            <!-- Info Empresa -->
            <div class="footer-brand">
                <h3><?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?></h3>
                <p><?= View::e($settings['about_text'] ?? 'Seleccionamos cada flor con esmero para crear recuerdos imborrables y detalles que llenan el corazón.') ?></p>
                <div class="footer-social-links">
                    <?php if (!empty($settings['instagram_url'])): ?>
                        <a href="<?= View::e($settings['instagram_url']) ?>" target="_blank" class="footer-social-btn" title="Instagram"><?= View::icon('instagram', 18) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['facebook_url'])): ?>
                        <a href="<?= View::e($settings['facebook_url']) ?>" target="_blank" class="footer-social-btn" title="Facebook"><?= View::icon('facebook', 18) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['tiktok_url'])): ?>
                        <a href="<?= View::e($settings['tiktok_url']) ?>" target="_blank" class="footer-social-btn" title="TikTok"><?= View::icon('tiktok', 18) ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Enlaces Rápidos -->
            <div class="footer-col">
                <h4>Navegación</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li><a href="<?= BASE_URL ?>catalogo">Todos los Arreglos</a></li>
                    <li><a href="<?= BASE_URL ?>catalogo?categoria=ramos-bouquets-mano">Ramos y Bouquets</a></li>
                    <li><a href="<?= BASE_URL ?>catalogo?categoria=cajas-sombrereras-lujo">Cajas y Sombrereras</a></li>
                    <li><a href="<?= BASE_URL ?>catalogo?categoria=ramos-buchones-majestuosos">Ramos Buchones</a></li>
                    <li><a href="<?= BASE_URL ?>contacto">Contacto y Ubicación</a></li>
                </ul>
            </div>

            <!-- Horarios y Atención -->
            <div class="footer-col">
                <h4>Atención al Cliente</h4>
                <ul class="footer-links">
                    <li style="display:flex; align-items:center; gap:0.5rem;"><?= View::icon('pin', 16) ?> <?= View::e($settings['site_address'] ?? 'Av. El Sol 452, Cusco') ?></li>
                    <li style="display:flex; align-items:center; gap:0.5rem;"><?= View::icon('phone', 16) ?> <?= View::e($settings['site_phone'] ?? '+51 932 070 468') ?></li>
                    <li style="display:flex; align-items:center; gap:0.5rem;"><?= View::icon('mail', 16) ?> <?= View::e($settings['site_email'] ?? 'ventas@floreriatulisol.com') ?></li>
                    <li style="display:flex; align-items:center; gap:0.5rem;"><?= View::icon('clock', 16) ?> <?= View::e($settings['site_schedule'] ?? 'Lun a Dom: 8:00 AM - 9:00 PM') ?></li>
                </ul>
            </div>

            <!-- Medios de Pago y Seguridad -->
            <div class="footer-col">
                <h4>Pagos 100% Seguros</h4>
                <p style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 1rem;">
                    Aceptamos todas las tarjetas de crédito, débito y billeteras móviles mediante la pasarela segura de <strong>Culqi</strong>.
                </p>
                <div class="culqi-badge-strip">
                    <span class="wallet-badge badge-visa">VISA</span>
                    <span class="wallet-badge badge-master">Mastercard</span>
                    <span class="wallet-badge badge-yape">YAPE</span>
                    <span class="wallet-badge badge-plin">PLIN</span>
                </div>
            </div>
        </div>

        <div class="container footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?>. Todos los derechos reservados.</p>
            <p>Imágenes 100% optimizadas en formato WebP • Arquitectura MVC PHP</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= View::asset('assets/js/app.js') ?>"></script>
    <script src="<?= View::asset('assets/js/culqi-checkout.js') ?>"></script>
</body>
</html>
