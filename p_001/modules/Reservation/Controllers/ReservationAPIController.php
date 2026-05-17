<?php
namespace Modules\Reservation\Controllers;

use Modules\Reservation\Models\ReservationModel;

class ReservationAPIController {
    private $model;

    public function __construct() {
        $this->model = new ReservationModel();
    }

    private function requireAdmin() {
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

    public function create() {
        // Read JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        header('Content-Type: application/json');
        if (!$data) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid data payload"]);
            return;
        }

        $data['firstName'] = htmlspecialchars($data['firstName'] ?? '');
        $data['lastName'] = htmlspecialchars($data['lastName'] ?? '');
        $data['emailAdd'] = htmlspecialchars($data['emailAdd'] ?? '');
        $data['contactNum'] = htmlspecialchars($data['contactNum'] ?? '');

        // Check availability
        if ($this->model->checkAvailability($data['reserveDate'], $data['reserveTime'], $data['reserveFloor'], $data['reserveTable'])) {
            http_response_code(409); // Conflict
            echo json_encode(["status" => "error", "message" => "Table is already reserved."]);
            return;
        }

        try {
            $id = $this->model->createReservation($data);
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Reservation successful!", "id" => $id]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
    }

    public function index() {
        $this->requireAdmin();
        header('Content-Type: application/json');
        try {
            $reservations = $this->model->getAllReservations();
            echo json_encode(["status" => "success", "data" => $reservations]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
    }

    public function delete($id) {
        $this->requireAdmin();
        header('Content-Type: application/json');
        try {
            if ($this->model->deleteReservation($id)) {
                echo json_encode(["status" => "success", "message" => "Deleted successfully"]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Reservation not found"]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
    }
}
