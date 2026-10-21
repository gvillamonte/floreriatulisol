<?php
// ========================================================
// ThemeHelper - Paletas predefinidas de color por tema
// Florería Tulisol
// ========================================================

class ThemeHelper {

    /**
     * Nombres legibles de cada paleta.
     */
    public static function labels(): array {
        return [
            'yellow' => 'Flores Amarillas',
            'purple' => 'Flores Moradas',
            'blue'   => 'Flores Azules',
        ];
    }

    /**
     * Color representativo (hex) de cada paleta, para chips/badges.
     */
    public static function swatch(string $palette): string {
        return match ($palette) {
            'yellow' => '#F0B429',
            'purple' => '#A855C7',
            'blue'   => '#4A9FE8',
            default  => '#E85A82',
        };
    }

    /**
     * Variables CSS (:root) de cada paleta predefinida (pasteles suaves).
     */
    public static function palette(string $palette): array {
        return match ($palette) {
            'yellow' => [
                '--primary'        => '#F0B429',
                '--primary-light'  => '#F7D070',
                '--primary-lighter'=> '#FDF3D7',
                '--primary-subtle' => '#FFFCF0',
                '--primary-dark'   => '#B8860B',
                '--footer-bg'      => '#2A2010',
                '--footer-border'  => '#3D3018',
                '--footer-text'    => '#F5E6A8',
            ],
            'purple' => [
                '--primary'        => '#A855C7',
                '--primary-light'  => '#C77DDB',
                '--primary-lighter'=> '#F3E4FA',
                '--primary-subtle' => '#FCF7FE',
                '--primary-dark'   => '#7B1FA2',
                '--footer-bg'      => '#2A1533',
                '--footer-border'  => '#3D2247',
                '--footer-text'    => '#E1BEE7',
            ],
            'blue' => [
                '--primary'        => '#4A9FE8',
                '--primary-light'  => '#7DBBF0',
                '--primary-lighter'=> '#DCEEFC',
                '--primary-subtle' => '#F5FAFE',
                '--primary-dark'   => '#1E6BB8',
                '--footer-bg'      => '#132A3D',
                '--footer-border'  => '#1E3A52',
                '--footer-text'    => '#BBDEFB',
            ],
            default => [],
        };
    }

    /**
     * Genera el bloque <style> con las variables CSS del tema.
     */
    public static function cssVariables(string $palette): string {
        $vars = self::palette($palette);
        if (empty($vars)) {
            return '';
        }
        $lines = [];
        foreach ($vars as $var => $value) {
            $lines[] = "    {$var}: {$value};";
        }
        return ":root {\n" . implode("\n", $lines) . "\n}";
    }
}
