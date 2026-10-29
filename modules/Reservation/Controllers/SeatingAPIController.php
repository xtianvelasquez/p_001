<?php
namespace Modules\Reservation\Controllers;

use Modules\Reservation\Models\SeatingModel;

class SeatingAPIController {
    private SeatingModel $model;

    public function __construct() {
        $this->model = new SeatingModel();
    }

    private function requireAdmin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Unauthorized"]);
            exit;
        }
    }

    private function cleanString(mixed $value, int $maxLength = 255): string {
        $value = trim((string) ($value ?? ''));
        return substr($value, 0, $maxLength);
    }

    public function index(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        try {
            $floor = isset($_GET['floor']) ? $this->cleanString($_GET['floor'], 50) : null;
            $tables = $this->model->getAllTables($floor);
            $floors = $this->model->getFloors();

            echo json_encode([
                "status" => "success",
                "data" => [
                    "tables" => $tables,
                    "floors" => $floors
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Could not load seatings."]);
        }
    }

    public function create(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? [];

        $tableName = $this->cleanString($data['table_name'] ?? '', 50);
        $floorName = $this->cleanString($data['floor_name'] ?? '', 50);
        $capacity = filter_var($data['capacity'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 50]]);
        $area = $this->cleanString($data['area'] ?? 'Main Dining', 100);
        $description = $this->cleanString($data['description'] ?? '', 255);
        $isActive = isset($data['is_active']) ? (bool)$data['is_active'] : true;

        if ($tableName === '') {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Table name is required."]);
            return;
        }

        if ($floorName === '') {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Floor name is required."]);
            return;
        }

        if ($capacity === false) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Capacity must be an integer between 1 and 50."]);
            return;
        }

        if ($this->model->tableExists($tableName, $floorName)) {
            http_response_code(409);
            echo json_encode(["status" => "error", "message" => "A table named '{$tableName}' already exists on {$floorName}."]);
            return;
        }

        try {
            // Also ensure floor exists in restaurant_floors
            $this->model->createFloor($floorName);

            $id = $this->model->createTable([
                'table_name' => $tableName,
                'floor_name' => $floorName,
                'capacity' => $capacity,
                'area' => $area,
                'description' => $description,
                'is_active' => $isActive
            ]);

            http_response_code(201);
            echo json_encode([
                "status" => "success",
                "message" => "Table created successfully.",
                "table_id" => $id
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to create table."]);
        }
    }

    public function update(int|string $id): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $validatedId = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($validatedId === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid table ID."]);
            return;
        }

        $existing = $this->model->getTableById($validatedId);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Table not found."]);
            return;
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? [];

        $tableName = $this->cleanString($data['table_name'] ?? $existing['table_name'], 50);
        $floorName = $this->cleanString($data['floor_name'] ?? $existing['floor_name'], 50);
        $capacity = filter_var($data['capacity'] ?? $existing['capacity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 50]]);
        $area = $this->cleanString($data['area'] ?? $existing['area'], 100);
        $description = $this->cleanString($data['description'] ?? $existing['description'], 255);
        $isActive = isset($data['is_active']) ? (bool)$data['is_active'] : (bool)$existing['is_active'];

        if ($tableName === '' || $floorName === '') {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Table and floor names are required."]);
            return;
        }

        if ($capacity === false) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Capacity must be an integer between 1 and 50."]);
            return;
        }

        if ($this->model->tableExists($tableName, $floorName, $validatedId)) {
            http_response_code(409);
            echo json_encode(["status" => "error", "message" => "Another table named '{$tableName}' already exists on {$floorName}."]);
            return;
        }

        try {
            $this->model->createFloor($floorName);

            $this->model->updateTable($validatedId, [
                'table_name' => $tableName,
                'floor_name' => $floorName,
                'capacity' => $capacity,
                'area' => $area,
                'description' => $description,
                'is_active' => $isActive
            ]);

            echo json_encode(["status" => "success", "message" => "Table updated successfully."]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to update table."]);
        }
    }

    public function toggle(int|string $id): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $validatedId = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($validatedId === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid table ID."]);
            return;
        }

        try {
            $newStatus = $this->model->toggleTableStatus($validatedId);
            if ($newStatus === null) {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Table not found."]);
                return;
            }

            echo json_encode([
                "status" => "success",
                "message" => "Table status changed to " . ($newStatus ? "active" : "inactive") . ".",
                "is_active" => $newStatus
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to toggle table status."]);
        }
    }

    public function delete(int|string $id): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $validatedId = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($validatedId === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid table ID."]);
            return;
        }

        $table = $this->model->getTableById($validatedId);
        if (!$table) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Table not found."]);
            return;
        }

        // Check if table has active upcoming bookings
        $activeBookings = $this->model->countActiveReservationsForTable($table['floor_name'], $table['table_name']);
        if ($activeBookings > 0) {
            http_response_code(409);
            echo json_encode([
                "status" => "error",
                "message" => "Cannot delete '{$table['table_name']}' because it has {$activeBookings} active reservation(s). You can deactivate it instead to prevent future bookings."
            ]);
            return;
        }

        try {
            $this->model->deleteTable($validatedId);
            echo json_encode(["status" => "success", "message" => "Table deleted successfully."]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to delete table."]);
        }
    }

    public function floors(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        try {
            $floors = $this->model->getFloors();
            echo json_encode(["status" => "success", "data" => $floors]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Could not load floors."]);
        }
    }

    public function createFloor(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? [];

        $floorName = $this->cleanString($data['floor_name'] ?? '', 50);
        $description = $this->cleanString($data['description'] ?? '', 255);

        if ($floorName === '') {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Floor name is required."]);
            return;
        }

        try {
            $this->model->createFloor($floorName, $description);
            echo json_encode(["status" => "success", "message" => "Floor created."]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to create floor."]);
        }
    }
}
