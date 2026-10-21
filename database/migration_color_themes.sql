-- ========================================================
-- Migración: Sistema de Temas de Color por Fecha
-- Ejecutar en phpMyAdmin (InfinityFree o local)
-- ========================================================

-- 1. Tabla de temas de color por fecha
CREATE TABLE IF NOT EXISTS `color_themes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(80) NOT NULL,
    `palette` ENUM('yellow','purple','blue') NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Columna de color en productos (para filtrar regalos por tema)
ALTER TABLE `products`
    ADD COLUMN `color_theme` ENUM('none','yellow','purple','blue') NOT NULL DEFAULT 'none' AFTER `is_best_seller`;
