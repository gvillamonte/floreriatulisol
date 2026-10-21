<?php
// ========================================================
// Model Base - Florería Tulisol MVC
// ========================================================

// Carga explícita: en Linux (InfinityFree) el autoload no encuentra
// database.php por diferencia de mayúsculas/minúsculas
require_once __DIR__ . '/../../config/database.php';

class Model {
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function all(string $orderBy = 'id DESC'): array {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY {$orderBy}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id): ?array {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findBy(string $column, $value): ?array {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$column}` = :val LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['val' => $value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function where(string $column, $value, string $orderBy = 'id DESC'): array {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$column}` = :val ORDER BY {$orderBy}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['val' => $value]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO `{$this->table}` ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }

    public function update($id, array $data): bool {
        $fields = [];
        foreach (array_keys($data) as $key) {
            $fields[] = "`$key` = :$key";
        }
        $fieldsSql = implode(', ', $fields);

        $sql = "UPDATE `{$this->table}` SET {$fieldsSql} WHERE `{$this->primaryKey}` = :pk_id";
        $data['pk_id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id): bool {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function count(string $condition = '1=1', array $params = []): int {
        $sql = "SELECT COUNT(*) as total FROM `{$this->table}` WHERE {$condition}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
