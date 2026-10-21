<?php
// ========================================================
// AdminMenu - Registro dinámico del menú lateral del CMS
// Al agregar un módulo nuevo, REGÍSTRALO aquí indicando
// a qué grupo pertenece (ver GRUPOS disponibles abajo).
// ========================================================

class AdminMenu {

    /**
     * GRUPOS del sidebar. El orden del array define el orden visual.
     * Para agregar un grupo nuevo, añade una entrada aquí.
     * 'open' => true  → el acordeón nace expandido
     * 'open' => null  → se expande solo si contiene la ruta activa
     */
    public static function groups(): array {
        return [
            'main' => [
                'label' => 'Principal',
                'open'  => true,
            ],
            'catalog' => [
                'label' => 'Catálogo',
                'open'  => null,
            ],
            'sales' => [
                'label' => 'Ventas',
                'open'  => null,
            ],
            'config' => [
                'label' => 'Configuración',
                'open'  => null,
            ],
            'quick' => [
                'label' => 'Accesos',
                'open'  => false,
            ],
        ];
    }

    /**
     * ITEMS del menú. Cada item DEBE tener 'group' (clave del array groups()).
     * Al crear un módulo nuevo, agrega su entrada aquí preguntando al usuario
     * a qué grupo pertenece: main | catalog | sales | config | quick
     *
     * Campos:
     *  - label   : texto visible
     *  - url     : ruta relativa (sin BASE_URL) o URL absoluta si startsWith http
     *  - icon    : nombre de icono de IconHelper
     *  - match   : substring de la URI para marcar 'active' (opcional, default = url)
     *  - external: true si abre en pestaña nueva
     *  - danger  : true para estilos de cierre/eliminar
     */
    public static function items(): array {
        return [
            // ---- group: main ----
            [
                'group' => 'main',
                'label' => 'Dashboard',
                'url'   => 'admin',
                'icon'  => 'dashboard',
                'match' => '/admin',
            ],

            // ---- group: catalog ----
            [
                'group' => 'catalog',
                'label' => 'Arreglos y Ramos',
                'url'   => 'admin/productos',
                'icon'  => 'flower',
                'match' => 'admin/productos',
            ],
            [
                'group' => 'catalog',
                'label' => 'Categorías',
                'url'   => 'admin/categorias',
                'icon'  => 'tag',
                'match' => 'admin/categorias',
            ],

            // ---- group: sales ----
            [
                'group' => 'sales',
                'label' => 'Pedidos y Envíos',
                'url'   => 'admin/pedidos',
                'icon'  => 'package',
                'match' => 'admin/pedidos',
            ],

            // ---- group: config ----
            [
                'group' => 'config',
                'label' => 'Empresa y Culqi',
                'url'   => 'admin/configuracion',
                'icon'  => 'settings',
                'match' => 'admin/configuracion',
            ],
            [
                'group' => 'config',
                'label' => 'Temas de Color',
                'url'   => 'admin/temas',
                'icon'  => 'palette',
                'match' => 'admin/temas',
            ],

            // ---- group: quick ----
            [
                'group'    => 'quick',
                'label'    => 'Ver Tienda Pública',
                'url'      => '',
                'icon'     => 'globe',
                'external' => true,
            ],
            [
                'group' => 'quick',
                'label' => 'Cerrar Sesión',
                'url'   => 'admin/logout',
                'icon'  => 'logout',
                'danger' => true,
            ],
        ];
    }

    /**
     * Devuelve los grupos con sus items ya filtrados y con flag active.
     */
    public static function build(string $currentUri): array {
        $uri = rtrim($currentUri, '/');
        if ($uri === '') $uri = '/';

        $groups = self::groups();
        $items  = self::items();

        $result = [];
        foreach ($groups as $key => $g) {
            $result[$key] = [
                'label' => $g['label'],
                'open'  => $g['open'],
                'items' => [],
            ];
        }

        foreach ($items as $item) {
            $g = $item['group'] ?? null;
            if (!isset($result[$g])) continue;

            $match = $item['match'] ?? $item['url'];
            $isActive = false;

            if (!empty($item['external'])) {
                $isActive = false;
            } elseif ($match === '/admin') {
                $isActive = ($uri === '/admin' || str_ends_with($uri, '/admin'));
            } elseif ($match !== '') {
                $isActive = str_contains($uri, $match);
            }

            $result[$g]['items'][] = $item + ['active' => $isActive];
        }

        // Quitar grupos vacíos
        $result = array_filter($result, fn($g) => !empty($g['items']));

        // Auto-abrir grupo que contiene ruta activa (si open es null)
        foreach ($result as $key => &$g) {
            if ($g['open'] === null) {
                foreach ($g['items'] as $it) {
                    if (!empty($it['active'])) {
                        $g['open'] = true;
                        break;
                    }
                }
                if ($g['open'] === null) $g['open'] = false;
            }
            $g['open'] = (bool) $g['open'];
        }
        unset($g);

        return $result;
    }
}
