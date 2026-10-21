<?php
// ========================================================
// Setting Model - Florería Tulisol
// ========================================================

class Setting extends Model {
    protected string $table = 'settings';

    public function get(string $key, $default = null): ?string {
        $row = $this->findBy('setting_key', $key);
        return $row ? $row['setting_value'] : $default;
    }

    public function getAllGrouped(): array {
        $all = $this->all('setting_group ASC, id ASC');
        $result = [];
        foreach ($all as $item) {
            $result[$item['setting_key']] = $item['setting_value'];
        }
        return $result;
    }

    public function set(string $key, ?string $value, string $group = 'general'): bool {
        $existing = $this->findBy('setting_key', $key);
        if ($existing) {
            $sql = "UPDATE `settings` SET `setting_value` = :val WHERE `setting_key` = :key";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['val' => $value, 'key' => $key]);
        } else {
            $sql = "INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES (:key, :val, :grp)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['key' => $key, 'val' => $value, 'grp' => $group]);
        }
    }

    public function updateMultiple(array $settings): void {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }
}
