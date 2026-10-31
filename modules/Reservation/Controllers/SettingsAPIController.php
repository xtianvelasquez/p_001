<?php
namespace Modules\Reservation\Controllers;

use Modules\Reservation\Models\SettingsModel;

class SettingsAPIController {
    private SettingsModel $model;

    public function __construct() {
        $this->model = new SettingsModel();
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

    public function index(): void {
        header('Content-Type: application/json');
        try {
            $settings = $this->model->getAllSettings();
            $floors = $this->model->getActiveFloorsSummary();

            echo json_encode([
                "status" => "success",
                "data" => [
                    "settings" => $settings,
                    "active_floors" => $floors
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Could not load settings."]);
        }
    }

    public function update(): void {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? [];

        $allowedKeys = [
            'restaurant_name',
            'tagline',
            'operating_days',
            'opening_time',
            'closing_time',
            'is_open_today',
            'phone_number',
            'email_address',
            'street_address',
            'city_address',
            'map_url'
        ];

        $payload = [];
        foreach ($allowedKeys as $key) {
            if (isset($data[$key])) {
                $payload[$key] = trim((string)$data[$key]);
            }
        }

        if (empty($payload)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No valid settings provided."]);
            return;
        }

        try {
            $this->model->updateSettings($payload);
            echo json_encode(["status" => "success", "message" => "Restaurant settings updated successfully."]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to update settings."]);
        }
    }
}
