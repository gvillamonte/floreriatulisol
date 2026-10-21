<?php
// ========================================================
// Category Model - Florería Tulisol
// ========================================================

class Category extends Model {
    protected string $table = 'categories';

    public function getActive(): array {
        $sql = "SELECT c.*, COUNT(p.id) as product_count,
                (
                    SELECT p2.main_image FROM products p2
                    WHERE p2.category_id = c.id AND p2.is_active = 1
                    ORDER BY p2.is_featured DESC, p2.is_best_seller DESC, p2.id DESC
                    LIMIT 1
                ) as featured_image,
                (
                    SELECT p3.name FROM products p3
                    WHERE p3.category_id = c.id AND p3.is_active = 1
                    ORDER BY p3.is_featured DESC, p3.is_best_seller DESC, p3.id DESC
                    LIMIT 1
                ) as featured_product_name
                FROM `categories` c 
                LEFT JOIN `products` p ON c.id = p.category_id AND p.is_active = 1 
                WHERE c.is_active = 1 
                GROUP BY c.id 
                ORDER BY c.sort_order ASC, c.name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllWithCount(): array {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM `categories` c 
                LEFT JOIN `products` p ON c.id = p.category_id 
                GROUP BY c.id 
                ORDER BY c.sort_order ASC, c.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array {
        return $this->findBy('slug', $slug);
    }

    public function generateSlug(string $name, ?int $ignoreId = null): string {
        $base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $base = trim($base, '-');
        $slug = $base;
        $counter = 1;

        while (true) {
            $sql = "SELECT id FROM `categories` WHERE `slug` = :slug";
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
