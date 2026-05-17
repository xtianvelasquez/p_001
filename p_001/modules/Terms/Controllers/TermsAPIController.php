<?php
namespace Modules\Terms\Controllers;

use Modules\Terms\Models\TermsModel;

class TermsAPIController {
    private $model;

    public function __construct() {
        $this->model = new TermsModel();
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

    public function index() {
        header('Content-Type: application/json');
        try {
            $terms = $this->model->getAllTerms();
            echo json_encode(["status" => "success", "data" => $terms]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function create() {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid payload"]);
            return;
        }

        $data['tcTitle'] = htmlspecialchars($data['tcTitle'] ?? '');
        $data['tcDescription'] = htmlspecialchars($data['tcDescription'] ?? '');
        try {
            $this->model->createTerm($data['tcNum'], $data['tcTitle'], $data['tcDescription']);
            http_response_code(201);
            echo json_encode(["status" => "success", "message" => "Term created"]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function delete($num) {
        $this->requireAdmin();
        header('Content-Type: application/json');
        try {
            $this->model->deleteTerm($num);
            echo json_encode(["status" => "success", "message" => "Term deleted"]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
