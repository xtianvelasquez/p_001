<?php
namespace Modules\Reservation\Controllers;

use Modules\Reservation\Models\ReservationModel;

class ReservationAPIController {
    private $model;

    public function __construct() {
        $this->model = new ReservationModel();
    }

    public function create() {
        // Read JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid data payload"]);
            return;
        }

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
        try {
            $reservations = $this->model->getAllReservations();
            echo json_encode(["status" => "success", "data" => $reservations]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
    }

    public function delete($id) {
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
