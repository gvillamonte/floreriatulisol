<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | Florería Tulisol CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= View::asset('assets/css/style.css') ?>">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top right, #f8edf0 0%, #fcf6f8 40%, #fdfbf9 100%);
            padding: 1.5rem;
        }
        .login-box {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 20px;
            padding: 2.75rem 2.25rem;
            box-shadow: 0 15px 35px -5px rgba(158, 83, 101, 0.1);
            border: 1px solid #f5e4e8;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div style="display: flex; justify-content: center; margin-bottom: 1.25rem;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #fcf6f8; border: 1px solid #f5e4e8; display: flex; align-items: center; justify-content: center; color: var(--primary, #c4788c);">
                <?= View::icon('flower', 28) ?>
            </div>
        </div>
        <h2 style="font-family: var(--font-heading); font-size: 1.85rem; color: #332629; margin-bottom: 0.25rem;">
            <?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?>
        </h2>
        <p style="color: #6d5b60; font-size: 0.875rem; margin-bottom: 2rem;">
            Panel de Control y Administración CMS
        </p>

        <?php if (Session::hasFlash('error')): ?>
            <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 0.85rem; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
                <?= View::icon('alert', 18) ?> <span><?= Session::getFlash('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (Session::hasFlash('success')): ?>
            <div style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 0.85rem; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
                <?= View::icon('check', 18) ?> <span><?= Session::getFlash('success') ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>admin/login" method="POST" style="text-align: left;">
            <div class="form-group">
                <label class="form-label" for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" value="admin@floreriatulisol.com" required autofocus>
            </div>

            <div class="form-group" style="margin-bottom: 1.75rem;">
                <label class="form-label" for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" value="admin12345*" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem;">
                Ingresar al CMS
            </button>
        </form>

        <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #f5e4e8; font-size: 0.8rem; color: #6d5b60;">
            <p style="margin-bottom: 0.5rem;">Credenciales de prueba:</p>
            <code style="background: #fcf6f8; padding: 0.2rem 0.5rem; border-radius: 4px; color: #332629; border: 1px solid #f5e4e8;">admin@floreriatulisol.com / admin12345*</code>
        </div>

        <div style="margin-top: 1.5rem;">
            <a href="<?= BASE_URL ?>" style="font-size: 0.85rem; color: var(--primary); font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('arrow-left', 14) ?> Volver a la Tienda Pública
            </a>
        </div>
    </div>

</body>
</html>
