<?php
namespace Modules\Reservation\Models;

use Core\Database;
use PDO;

class SeatingModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllTables(?string $floor = null): array {
        if ($floor && $floor !== '') {
            $stmt = $this->db->prepare("SELECT * FROM restaurant_tables WHERE floor_name = :floor ORDER BY floor_name ASC, table_id ASC");
            $stmt->execute([':floor' => $floor]);
        } else {
            $stmt = $this->db->query("SELECT * FROM restaurant_tables ORDER BY floor_name ASC, table_id ASC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTableById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM restaurant_tables WHERE table_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createTable(array $data): int {
        $stmt = $this->db->prepare("INSERT INTO restaurant_tables (table_name, floor_name, capacity, area, description, is_active) 
            VALUES (:name, :floor, :capacity, :area, :description, :is_active) 
            RETURNING table_id");
        $stmt->execute([
            ':name' => $data['table_name'],
            ':floor' => $data['floor_name'],
            ':capacity' => (int)$data['capacity'],
            ':area' => $data['area'] ?? 'Main Dining',
            ':description' => $data['description'] ?? null,
            ':is_active' => (!isset($data['is_active']) || $data['is_active']) ? 'true' : 'false'
        ]);
        return (int)$stmt->fetchColumn();
    }

    public function updateTable(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE restaurant_tables 
            SET table_name = :name, 
                floor_name = :floor, 
                capacity = :capacity, 
                area = :area, 
                description = :description, 
                is_active = :is_active, 
                updated_at = CURRENT_TIMESTAMP 
            WHERE table_id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $data['table_name'],
            ':floor' => $data['floor_name'],
            ':capacity' => (int)$data['capacity'],
            ':area' => $data['area'] ?? 'Main Dining',
            ':description' => $data['description'] ?? null,
            ':is_active' => (!isset($data['is_active']) || $data['is_active']) ? 'true' : 'false'
        ]);
        return $stmt->rowCount() > 0;
    }

    public function toggleTableStatus(int $id): ?bool {
        $table = $this->getTableById($id);
        if (!$table) {
            return null;
        }
        $newStatus = !$table['is_active'];
        $stmt = $this->db->prepare("UPDATE restaurant_tables SET is_active = :status, updated_at = CURRENT_TIMESTAMP WHERE table_id = :id");
        $stmt->execute([
            ':id' => $id, 
            ':status' => $newStatus ? 'true' : 'false'
        ]);
        return $newStatus;
    }

    public function deleteTable(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM restaurant_tables WHERE table_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function countActiveReservationsForTable(string $floor, string $table): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservation_info 
            WHERE reservation_floor = :floor 
              AND reservation_table = :table 
              AND status IN ('pending', 'confirmed', 'seated')
              AND reservation_date >= CURRENT_DATE");
        $stmt->execute([':floor' => $floor, ':table' => $table]);
        return (int)$stmt->fetchColumn();
    }

    public function tableExists(string $tableName, string $floorName, ?int $excludeId = null): bool {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM restaurant_tables WHERE UPPER(table_name) = UPPER(:table) AND UPPER(floor_name) = UPPER(:floor) AND table_id != :id");
            $stmt->execute([':table' => $tableName, ':floor' => $floorName, ':id' => $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM restaurant_tables WHERE UPPER(table_name) = UPPER(:table) AND UPPER(floor_name) = UPPER(:floor)");
            $stmt->execute([':table' => $tableName, ':floor' => $floorName]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getFloors(): array {
        // Fetch floors from restaurant_floors table, plus distinct from restaurant_tables
        $stmt = $this->db->query("SELECT floor_name, description, is_active FROM restaurant_floors ORDER BY floor_name ASC");
        $floors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Also check if any table has a floor not yet in restaurant_floors
        $existing = array_column($floors, 'floor_name');
        $stmt2 = $this->db->query("SELECT DISTINCT floor_name FROM restaurant_tables ORDER BY floor_name ASC");
        $tableFloors = $stmt2->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tableFloors as $tf) {
            if (!in_array($tf, $existing, true)) {
                $floors[] = [
                    'floor_name' => $tf,
                    'description' => '',
                    'is_active' => true
                ];
            }
        }
        return $floors;
    }

    public function createFloor(string $floorName, ?string $description = null): bool {
        $stmt = $this->db->prepare("INSERT INTO restaurant_floors (floor_name, description) VALUES (:name, :desc) ON CONFLICT (floor_name) DO NOTHING");
        $stmt->execute([
            ':name' => trim($floorName),
            ':desc' => $description ? trim($description) : null
        ]);
        return $stmt->rowCount() > 0;
    }
}
