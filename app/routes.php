<?php
// ========================================================
// Definición de Rutas del Sistema MVC - Florería Tulisol
// ========================================================

$router = Router::getInstance();

// --------------------------------------------------------
// Rutas Públicas (Frontend)
// --------------------------------------------------------
$router->get('/',                 'HomeController@index');
$router->get('/catalogo',         'CatalogController@index');
$router->get('/producto/{slug}',  'CatalogController@detail');
$router->get('/carrito',          'CartController@index');
$router->get('/checkout',         'CheckoutController@index');
$router->get('/pedido/confirmacion/{code}', 'CheckoutController@confirmation');
$router->get('/contacto',         'ContactController@index');
$router->post('/contacto/enviar', 'ContactController@send');

// --------------------------------------------------------
// Rutas API (Carrito y Pasarela Culqi)
// --------------------------------------------------------
$router->get('/api/cart',         'CartApiController@get');
$router->post('/api/cart/add',    'CartApiController@add');
$router->post('/api/cart/update', 'CartApiController@update');
$router->post('/api/cart/remove', 'CartApiController@remove');
$router->post('/api/cart/clear',  'CartApiController@clear');

$router->post('/api/culqi/charge',        'CulqiApiController@charge');
$router->post('/api/order/offline',       'CulqiApiController@offlineOrder');

// --------------------------------------------------------
// Rutas de Autenticación Admin
// --------------------------------------------------------
$router->get('/admin/login',      'AuthController@login');
$router->post('/admin/login',     'AuthController@authenticate');
$router->get('/admin/logout',     'AuthController@logout');

// --------------------------------------------------------
// Rutas Protegidas del CMS Panel (Middleware: auth)
// --------------------------------------------------------
$router->get('/admin',            'DashboardController@index', ['auth']);

// Productos / Arreglos
$router->get('/admin/productos',                'ProductController@index',  ['auth']);
$router->get('/admin/productos/crear',          'ProductController@create', ['auth']);
$router->post('/admin/productos/guardar',       'ProductController@store',  ['auth']);
$router->get('/admin/productos/editar/{id}',    'ProductController@edit',   ['auth']);
$router->post('/admin/productos/actualizar/{id}','ProductController@update', ['auth']);
$router->post('/admin/productos/eliminar/{id}', 'ProductController@delete', ['auth']);
$router->post('/admin/productos/toggle/{id}',   'ProductController@toggle', ['auth']);

// Categorías
$router->get('/admin/categorias',               'CategoryController@index',  ['auth']);
$router->post('/admin/categorias/guardar',      'CategoryController@store',  ['auth']);
$router->post('/admin/categorias/actualizar/{id}','CategoryController@update', ['auth']);
$router->post('/admin/categorias/eliminar/{id}','CategoryController@delete', ['auth']);
$router->post('/admin/categorias/orden/{id}',   'CategoryController@reorder', ['auth']);

// Pedidos
$router->get('/admin/pedidos',                  'OrderController@index',         ['auth']);
$router->get('/admin/pedidos/detalle/{id}',     'OrderController@detail',        ['auth']);
$router->post('/admin/pedidos/estado/{id}',     'OrderController@updateStatus',  ['auth']);
$router->post('/admin/pedidos/pago/{id}',       'OrderController@updatePayment', ['auth']);

// Configuración de la Empresa y Pasarela Culqi
$router->get('/admin/configuracion',            'SettingsController@index',  ['auth']);
$router->post('/admin/configuracion/guardar',   'SettingsController@update', ['auth']);

// Temas de Color por Fecha
$router->get('/admin/temas',                          'ThemeController@index',  ['auth']);
$router->get('/admin/temas/crear',                    'ThemeController@create', ['auth']);
$router->post('/admin/temas/guardar',                 'ThemeController@store',  ['auth']);
$router->get('/admin/temas/{id}/editar',              'ThemeController@edit',   ['auth']);
$router->post('/admin/temas/{id}/actualizar',         'ThemeController@update', ['auth']);
$router->post('/admin/temas/{id}/eliminar',           'ThemeController@delete', ['auth']);
