<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | Florería Tulisol</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= View::asset('assets/css/style.css') ?>">
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #fdfbf9; padding: 2rem;">

    <div style="text-align: center; max-width: 520px; background: #fff; padding: 3.5rem 2rem; border-radius: 24px; box-shadow: 0 10px 30px rgba(158, 83, 101, 0.08); border: 1px solid #f5e4e8;">
        <div style="margin-bottom: 1.5rem; color: #c4788c; display: flex; justify-content: center;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #fcf6f8; display: flex; align-items: center; justify-content: center; border: 1px solid #f5e4e8;">
                <?= View::icon('search', 36) ?>
            </div>
        </div>
        <h1 style="font-size: 3rem; color: #9e5365; margin-bottom: 0.5rem; font-family: 'Playfair Display', serif;">404</h1>
        <h2 style="font-size: 1.5rem; color: #332629; margin-bottom: 1rem;">Página no encontrada</h2>
        <p style="color: #6d5b60; margin-bottom: 2rem;">
            Lo sentimos, el ramo o la página que buscas no existe o ha sido movida.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="<?= BASE_URL ?>" class="btn btn-primary">Ir al Inicio</a>
            <a href="<?= BASE_URL ?>catalogo" class="btn btn-secondary">Ver Catálogo</a>
        </div>
    </div>

</body>
</html>
