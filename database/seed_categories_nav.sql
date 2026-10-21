-- ========================================================
-- Categorías de navegación del header
-- Ejecutar en phpMyAdmin (InfinityFree o local)
-- ========================================================

INSERT INTO `categories` (`name`, `slug`, `description`, `icon`, `sort_order`, `is_active`) VALUES
('Arreglos Florales',           'arreglos-florales',           'Ramos, bouquets y arreglos florales para toda ocasión.',                    'grid',     10, 1),
('Colección Peluches',          'coleccion-peluches',          'Adorables peluches para regalar en combo con flores.',                     'gift',     20, 1),
('Chocolates & Dulzura',        'chocolates-dulzura',          'Chocolates premium y dulces para endulzar cualquier detalle.',             'heart',    30, 1),
('Globos & Diseños Exclusivos', 'globos-disenos-exclusivos',   'Globos metálicos, personalizados y diseños exclusivos.',                   'balloon',  40, 1),
('Complementos & Detalles Plus','complementos-detalles-plus',  'Tarjetas, peluches pequeños, velas y detalles complementarios.',           'package',  50, 1),
('Flores Amarillas',            'flores-amarillas',            'Ramos y arreglos con flores amarillas, alegres y luminosas.',              'sun',      60, 1),
('Flores Eternas',              'flores-eternas',              'Arreglos con flores preservadas que duran por años.',                      'flower',   70, 1),
('Especial de Halloween',       'especial-halloween',          'Arreglos y detalles temáticos para Halloween.',                            'sparkles', 80, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);
