<?php
namespace Modules\Reservation\Controllers;

use Modules\Reservation\Models\ReservationModel;

class ReservationAPIController {
    private $model;
    private $validStatuses = ['pending', 'confirmed', 'seated', 'completed', 'cancelled', 'no_show'];

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

    private function cleanString($value, $maxLength = 255) {
        $value = trim((string) ($value ?? ''));
        return substr($value, 0, $maxLength);
    }

    private function validateReservation($data) {
        $required = ['firstName', 'lastName', 'age', 'contactNum', 'emailAdd', 'reserveDate', 'reserveTime', 'numGuest', 'reserveFloor', 'reserveTable'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                return ucfirst($field) . " is required.";
            }
        }

        if (!filter_var($data['emailAdd'], FILTER_VALIDATE_EMAIL)) {
            return "Please enter a valid email address.";
        }

        if (!preg_match('/^\+63\d{10}$/', $data['contactNum'])) {
            return "Please enter a valid Philippine contact number.";
        }

        $age = filter_var($data['age'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 80]]);
        if ($age === false) {
            return "Age must be between 18 and 80.";
        }

        $guestCount = filter_var($data['numGuest'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 13]]);
        if ($guestCount === false) {
            return "Guest count must be between 1 and 13.";
        }

        $reservationDate = \DateTime::createFromFormat('!Y-m-d', $data['reserveDate']);
        $tomorrow = new \DateTime('tomorrow');
        $tomorrow->setTime(0, 0, 0);
        if (!$reservationDate || $reservationDate < $tomorrow) {
            return "Reservations must be booked at least one day in advance.";
        }

        return null;
    }

    private function generateConfirmationCode() {
        return 'BH-' . strtoupper(bin2hex(random_bytes(3)));
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

        $data['firstName'] = $this->cleanString($data['firstName'] ?? '', 100);
        $data['lastName'] = $this->cleanString($data['lastName'] ?? '', 100);
        $data['emailAdd'] = $this->cleanString($data['emailAdd'] ?? '', 100);
        $data['contactNum'] = $this->cleanString($data['contactNum'] ?? '', 15);
        $data['reserveDate'] = $this->cleanString($data['reserveDate'] ?? '', 10);
        $data['reserveTime'] = $this->cleanString($data['reserveTime'] ?? '', 10);
        $data['reserveFloor'] = $this->cleanString($data['reserveFloor'] ?? '', 20);
        $data['reserveTable'] = $this->cleanString($data['reserveTable'] ?? '', 20);
        $data['occasion'] = $this->cleanString($data['occasion'] ?? '', 100);
        $data['specialRequest'] = $this->cleanString($data['specialRequest'] ?? '', 1000);

        $validationError = $this->validateReservation($data);
        if ($validationError) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => $validationError]);
            return;
        }

        $tableInfo = $this->model->getTableInfo($data['reserveFloor'], $data['reserveTable']);
        if (!$tableInfo) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "The selected table does not exist."]);
            return;
        }
        if (!$tableInfo['is_active']) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "The selected table is currently inactive."]);
            return;
        }
        if ($tableInfo['capacity'] < $data['numGuest']) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "The selected table capacity is insufficient for the number of guests."]);
            return;
        }

        // Check availability
        if ($this->model->checkAvailability($data['reserveDate'], $data['reserveTime'], $data['reserveFloor'], $data['reserveTable'])) {
            http_response_code(409); // Conflict
            echo json_encode(["status" => "error", "message" => "Table is already reserved."]);
            return;
        }

        try {
            $data['confirmationCode'] = $this->generateConfirmationCode();
            $id = $this->model->createReservation($data);
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Reservation successful!", "id" => $id, "confirmationCode" => $data['confirmationCode']]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "We could not complete the reservation. Please try another time slot."]);
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

    public function availability() {
        header('Content-Type: application/json');

        $date = $this->cleanString($_GET['date'] ?? '', 10);
        $time = $this->cleanString($_GET['time'] ?? '', 10);
        $guests = filter_var($_GET['guests'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 13]]);

        if (!$date || !$time || $guests === false) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Date, time, and guest count are required."]);
            return;
        }

        try {
            $tables = $this->model->getAvailableTables($date, $time, $guests);
            echo json_encode(["status" => "success", "data" => $tables]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Could not load available tables."]);
        }
    }

    public function update($id) {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $id = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid reservation ID."]);
            return;
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $status = $this->cleanString($data['status'] ?? '', 20);

        if (!in_array($status, $this->validStatuses, true)) {
            http_response_code(422);
            echo json_encode(["status" => "error", "message" => "Invalid reservation status."]);
            return;
        }

        try {
            if ($this->model->updateStatus($id, $status)) {
                echo json_encode(["status" => "success", "message" => "Reservation updated."]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "Reservation not found."]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Could not update reservation."]);
        }
    }

    public function delete($id) {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $id = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid reservation ID."]);
            return;
        }
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
