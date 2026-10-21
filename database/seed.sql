USE `dbfloreriatulisol`;

-- ========================================================
-- 1. Insertar Usuario Administrador Inicial
-- Email: admin@floreriatulisol.com
-- Contraseña temporal: admin12345*
-- ========================================================
DELETE FROM `users` WHERE `email` = 'admin@floreriatulisol.com';
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Administrador Tulisol', 'admin@floreriatulisol.com', '$2y$10$Cp6aa6P7VjUcM8PPVQYGf.xBwd6LsJjNEw9H2tqc5H7x7DEhFdTE6', 'admin');

-- ========================================================
-- 2. Insertar Configuraciones del Negocio / Empresa
-- Paleta elegante: Palo Rosa Claro y Tonos Marfil / Neutros
-- ========================================================
DELETE FROM `settings`;
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_name', 'Florería Tulisol', 'general'),
('site_tagline', 'Arte floral, delicadeza en palo rosa y detalles inolvidables', 'general'),
('site_logo', 'uploads/branding/logo.webp', 'general'),
('site_favicon', 'uploads/branding/favicon.webp', 'general'),
('site_phone', '+51 932 070 468', 'contact'),
('site_whatsapp', '51932070468', 'contact'),
('site_whatsapp_msg', '¡Hola Florería Tulisol! Quisiera consultar sobre un tipo de arreglo floral.', 'contact'),
('site_email', 'ventas@floreriatulisol.com', 'contact'),
('site_address', 'Av. El Sol 452, Centro Histórico, Cusco - Perú', 'contact'),
('site_schedule', 'Lunes a Domingo: 8:00 AM - 9:00 PM', 'contact'),
('site_maps_embed', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3879.3875323498877!2d-71.9774!3d-13.5183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDMxJzA1LjkiUyA3McKwNTgnMzguNiJX!5e0!3m2!1ses!2spe!4v1600000000000!5m2!1ses!2spe" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'contact'),
('about_title', 'Creando momentos inolvidables en tonos cálidos y delicados', 'about'),
('about_subtitle', 'Diseños Florales Exclusivos en Palo Rosa y Tonos Neutros', 'about'),
('about_text', 'En Florería Tulisol cultivamos la armonía y la delicadeza en cada arreglo. Seleccionamos flores frescas cada madrugada, fusionando la dulzura del palo rosa claro con marfiles, cremas y follajes eucalipto. Cada diseño es una pieza de arte artesanal creada para tocar las fibras del corazón.', 'about'),
('about_mission', 'Llevar alegría, consuelo y amor mediante arreglos florales elegantes, sofisticados y entregas puntuales garantizadas.', 'about'),
('instagram_url', 'https://instagram.com/floreriatulisol', 'social'),
('facebook_url', 'https://facebook.com/floreriatulisol', 'social'),
('tiktok_url', 'https://tiktok.com/@floreriatulisol', 'social'),
('culqi_public_key', 'pk_test_a0d8b3684a0d9239', 'culqi'),
('culqi_secret_key', 'sk_test_7f1c137baef9f4a1', 'culqi'),
('culqi_mode', 'test', 'culqi'),
('currency_symbol', 'S/', 'ecommerce'),
('currency_code', 'PEN', 'ecommerce'),
('delivery_cost', '15.00', 'ecommerce'),
('free_shipping_threshold', '250.00', 'ecommerce');

-- ========================================================
-- 3. Categorización por Tipos de Arreglos Florales
-- ========================================================
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'Ramos y Bouquets de Mano', 'ramos-bouquets-mano', 'Ramos envueltos en papel coreano mate, gasa y lazos de seda fina para entregar en mano.', 'uploads/categories/cat-bouquets.webp', 'flower-2', 1, 1),
(2, 'Cajas y Sombrereras (Flower Boxes)', 'cajas-sombrereras-lujo', 'Diseños contemporáneos presentados en sombrereras rígidas circulares o cuadradas con hidratación prolongada.', 'uploads/categories/cat-cajas.webp', 'gift', 2, 1),
(3, 'Arreglos en Jarrón y Florero', 'arreglos-jarron-florero', 'Composiciones florales montadas en bases de vidrio o cerámica fina listas para lucir en mesas y salas.', 'uploads/categories/cat-jarrones.webp', 'sparkles', 3, 1),
(4, 'Ramos Buchones Majestuosos', 'ramos-buchones-majestuosos', 'Impactantes arreglos gigantes de 50 a 100 rosas con coronas doradas sutiles y detalles de gran impacto.', 'uploads/categories/cat-buchones.webp', 'crown', 4, 1),
(5, 'Canastas Florales Silvestres', 'canastas-florales-silvestres', 'Arreglos campestres y cálidos elaborados en canastas de mimbre tejidas con flores variadas de temporada.', 'uploads/categories/cat-canastas.webp', 'sun', 5, 1),
(6, 'Condolencias y Arreglos Fúnebres', 'condolencias-funebres', 'Homenajes solemnes de respeto con coronas, mantos y pedestales en tonos blancos, marfil y pasteles serenos.', 'uploads/categories/cat-funebres.webp', 'heart-handshake', 6, 1);

-- ========================================================
-- 4. Arreglos Florales Categorizados con Estética Palo Rosa
-- ========================================================
DELETE FROM `products`;
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `price`, `sale_price`, `short_description`, `description`, `flowers_included`, `care_tips`, `main_image`, `stock`, `is_featured`, `is_best_seller`, `is_active`) VALUES
(1, 1, 'Bouquet Palo Rosa y Rosas Nude', 'bouquet-palo-rosa-rosas-nude', 139.00, 119.00, 'Delicado ramo de mano con 18 rosas en tono palo rosa claro y marfil, envueltas en papel mate blush.', 'Una expresión sublime de romanticismo y ternura. Este bouquet reúne rosas premium en tono palo rosa suave y beige crema, combinadas con toques de eucalipto dólar y gypsophila blanca vaporosa.', '18 Rosas seleccionadas en palo rosa claro y marfil, follaje de eucalipto cinerea, gypsophila.', 'Recortar los tallos 2 cm en ángulo cada dos días y colocar en agua fresca.', 'uploads/products/bouquet-palo-rosa.webp', 35, 1, 1, 1),

(2, 2, 'Sombrerera Rose Pastel y Tulipanes', 'sombrerera-rose-pastel-tulipanes', 179.00, 159.00, 'Elegante sombrerera cilíndrica palo rosa con 20 tulipanes holandeses en matices pastel y hortensias.', 'Presentación refinada en caja rígida con cinta de seda. Cada flor reposa en una esponja floral con hidratación constante, ideal para obsequiar sin necesidad de jarrón inmediato.', '20 Tulipanes holandeses en tonos palo rosa suave y crema, hortensias deshidratadas, ruscus verde oliva.', 'Añadir medio vaso de agua fresca al centro de la sombrerera cada 24 horas.', 'uploads/products/sombrerera-tulipanes.webp', 25, 1, 1, 1),

(3, 3, 'Jarrón Cristal Sinfonía Marfil y Rose', 'jarron-cristal-sinfonia-marfil-rose', 165.00, 145.00, 'Composición en jarrón de cristal cilíndrico con lirios blancos, rosas palo rosa y claveles importados.', 'Diseño de altura y prestancia perfecto para sala o recepción. Las flores se entregan armoniosamente dispuestas en agua tratada con conservante floral de larga duración.', 'Lirios Casablanca marfil, 12 rosas palo rosa claro, clavelinas importadas, eucalipto baby blue.', 'Mantener el agua transparente y cambiarla cada 3 días manteniendo las hojas fuera del agua.', 'uploads/products/jarron-sinfonia.webp', 20, 1, 0, 1),

(4, 4, 'Ramo Buchón Serenidad - 100 Rosas', 'ramo-buchon-serenidad-100-rosas', 420.00, 380.00, 'Impresionante arreglo buchón de 100 rosas en degradé de palo rosa suave a crema con lazo satinado.', 'La cúspide del arte floral contemporáneo. Cien rosas de tallo largo seleccionadas por su apertura impecable, con envoltorio multicapa coreano en tonos arena y palo rosa empolvado.', '100 Rosas premium en paleta palo rosa y marfil, papel coreano impermeable mate, lazo de seda doble.', 'Rociar los pétalos suavemente con agua filtrada y conservar en un espacio fresco y ventilado.', 'uploads/products/buchon-serenidad.webp', 15, 1, 1, 1),

(5, 5, 'Canasta Campestre Flores del Alba', 'canasta-campestre-flores-del-alba', 129.00, 109.00, 'Hermosa canasta artesanal de mimbre con girasoles suaves, rosas palo rosa y margaritas silvestres.', 'Transmite paz, gratitud y calidez familiar. Canasta tejida a mano con follaje silvestre y una mezcla sutil de flores frescas que alegran cualquier rincón del hogar.', 'Rosas palo rosa, girasoles medianos en tono miel suave, margaritas crema, lavanda y follaje fino.', 'Hidratar la base de la canasta con una taza pequeña de agua fría interdiario.', 'uploads/products/canasta-del-alba.webp', 30, 0, 1, 1),

(6, 6, 'Corona Funeral Paz Eterna y Marfil', 'corona-funeral-paz-eterna-marfil', 230.00, 199.00, 'Solemne corona de condolencias con lirios marfil, rosas blancas, toques blush y atril de madera.', 'Homenaje de respeto, serenidad y afecto sincero. Incluye cinta dedicatoria impresa en tono sobrio y soporte de trípode de madera natural para velatorio o parroquia.', 'Lirios marfil Casablanca, 24 rosas blancas y blush, crisantemos de seda, hojas de palma y helecho.', 'Instalación garantizada en el lugar de velación con atril incluido.', 'uploads/products/corona-paz-eterna.webp', 18, 0, 0, 1),

(7, 1, 'Bouquet Silvestre Romance Francés', 'bouquet-silvestre-romance-frances', 115.00, NULL, 'Ramo estilo desenfadado con rosas inglesas palo rosa, lisianthus blancos y eucalipto aromático.', 'La sutileza de los jardines franceses en tus manos. Texturas orgánicas, colores neutros que combinan armoniosamente con cualquier espacio.', 'Rosas palo rosa claro, lisianthus crema, eucalipto cinerea y flor de cera.', 'Cortar las puntas cada dos días y mantener lejos de corrientes de aire cálido.', 'uploads/products/romance-frances.webp', 25, 0, 0, 1),

(8, 2, 'Luxury Box Cuadrada Rosas y Bombones', 'luxury-box-cuadrada-rosas-bombones', 149.00, 129.00, 'Caja rígida cuadrada forrada en lino blush con 16 rosas palo rosa y delicada bombonera artesanal.', 'El balance perfecto entre elegancia visual y dulzura. Diseño de autor para aniversarios o cumpleaños especiales.', '16 Rosas palo rosa de invernadero, 6 bombones artesanales finos, caja de lujo reutilizable.', 'Mantener la esponja interna ligeramente húmeda y conservar los bombones a temperatura fresca.', 'uploads/products/luxury-box-cuadrada.webp', 20, 1, 0, 1);
