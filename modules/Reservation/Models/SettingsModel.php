<?php
namespace Modules\Reservation\Models;

use Core\Database;
use PDO;

class SettingsModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllSettings(): array {
        $stmt = $this->db->query("SELECT setting_key, setting_value, description FROM restaurant_settings");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function getSetting(string $key, ?string $default = null): ?string {
        $stmt = $this->db->prepare("SELECT setting_value FROM restaurant_settings WHERE setting_key = :key LIMIT 1");
        $stmt->execute([':key' => $key]);
        $val = $stmt->fetchColumn();
        return ($val !== false) ? (string)$val : $default;
    }

    public function updateSettings(array $keyValues): bool {
        $stmt = $this->db->prepare("INSERT INTO restaurant_settings (setting_key, setting_value, updated_at) 
            VALUES (:key, :val, CURRENT_TIMESTAMP) 
            ON CONFLICT (setting_key) 
            DO UPDATE SET setting_value = EXCLUDED.setting_value, updated_at = CURRENT_TIMESTAMP");

        foreach ($keyValues as $key => $val) {
            $stmt->execute([
                ':key' => (string)$key,
                ':val' => (string)$val
            ]);
        }
        return true;
    }

    public function getActiveFloorsSummary(): array {
        $stmt = $this->db->query("SELECT DISTINCT floor_name FROM restaurant_tables WHERE is_active = true ORDER BY floor_name ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
