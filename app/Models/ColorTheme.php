<?php
// ========================================================
// ColorTheme Model - Temas de Color por Fecha
// Florería Tulisol
// ========================================================

class ColorTheme extends Model {
    protected string $table = 'color_themes';

    /**
     * Devuelve el tema activo cuyo rango de fechas incluye hoy.
     */
    public function getActiveTheme(): ?array {
        $sql = "SELECT * FROM `color_themes`
                WHERE is_active = 1
                  AND CURDATE() BETWEEN start_date AND end_date
                ORDER BY sort_order ASC, id ASC
                LIMIT 1";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Listar todos los temas ordenados para el admin.
     */
    public function getAllThemes(): array {
        $sql = "SELECT * FROM `color_themes` ORDER BY sort_order ASC, start_date DESC, id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Clasifica el estado de un tema para mostrar en el admin.
     */
    public static function statusOf(array $theme): string {
        $today = date('Y-m-d');
        if (!$theme['is_active']) {
            return 'inactive';
        }
        if ($today < $theme['start_date']) {
            return 'scheduled';
        }
        if ($today > $theme['end_date']) {
            return 'expired';
        }
        return 'active_today';
    }
}
