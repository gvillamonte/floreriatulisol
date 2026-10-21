<?php
// ========================================================
// Product Model - Florería Tulisol
// ========================================================

class Product extends Model {
    protected string $table = 'products';

    public function getAllWithCategory(string $orderBy = 'p.id DESC'): array {
        $sql = "SELECT p.*, c.name as category_name 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                ORDER BY {$orderBy}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getFeatured(int $limit = 8): array {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.is_featured = 1 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBestSellers(int $limit = 6): array {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.is_best_seller = 1 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Destacados con los productos del color del tema activo primero.
     */
    public function getFeaturedByTheme(string $palette, int $limit = 8): array {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.is_featured = 1 
                ORDER BY (p.color_theme = :palette) DESC, p.id DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':palette', $palette);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Más vendidos con los productos del color del tema activo primero.
     */
    public function getBestSellersByTheme(string $palette, int $limit = 6): array {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.is_best_seller = 1 
                ORDER BY (p.color_theme = :palette) DESC, p.id DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':palette', $palette);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.slug = :slug LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getRelated(int $productId, ?int $categoryId, int $limit = 4): array {
        $sql = "SELECT p.*, c.name as category_name 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.id != :pid";
        $params = ['pid' => $productId];

        if ($categoryId) {
            $sql .= " AND p.category_id = :cid";
            $params['cid'] = $categoryId;
        }

        $sql .= " ORDER BY RAND() LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchAndFilter(
        ?int $categoryId = null,
        ?string $search = null,
        string $sort = 'default',
        int $limit = 12,
        int $offset = 0,
        ?string $themePalette = null
    ): array {
        $where = ["p.is_active = 1"];
        $params = [];

        if ($categoryId) {
            $where[] = "p.category_id = :cid";
            $params['cid'] = $categoryId;
        }

        if (!empty($search)) {
            $where[] = "(p.name LIKE :search OR p.description LIKE :search OR p.short_description LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        $whereClause = implode(' AND ', $where);

        $orderClause = match ($sort) {
            'price_asc'  => 'COALESCE(p.sale_price, p.price) ASC',
            'price_desc' => 'COALESCE(p.sale_price, p.price) DESC',
            'name_asc'   => 'p.name ASC',
            'popular'    => 'p.is_best_seller DESC, p.id DESC',
            default      => 'p.is_featured DESC, p.id DESC',
        };

        // Si hay tema de color activo, los productos de ese color van primero
        if (!empty($themePalette)) {
            $orderClause = "(p.color_theme = :theme_palette) DESC, " . $orderClause;
            $params['theme_palette'] = $themePalette;
        }

        // Contar total para paginación
        $countSql = "SELECT COUNT(*) as total FROM `products` p WHERE {$whereClause}";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetch()['total'];

        // Obtener productos
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM `products` p 
                LEFT JOIN `categories` c ON p.category_id = c.id 
                WHERE {$whereClause} 
                ORDER BY {$orderClause} 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        return [
            'items' => $items,
            'total' => $total,
            'pages' => ceil($total / max(1, $limit))
        ];
    }

    public function generateSlug(string $name, ?int $ignoreId = null): string {
        $base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $base = trim($base, '-');
        $slug = $base;
        $counter = 1;

        while (true) {
            $sql = "SELECT id FROM `products` WHERE `slug` = :slug";
            $params = ['slug' => $slug];
            if ($ignoreId !== null) {
                $sql .= " AND id != :ignoreId";
                $params['ignoreId'] = $ignoreId;
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            if (!$stmt->fetch()) {
                break;
            }
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
