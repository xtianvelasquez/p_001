<?php
namespace Modules\Terms\Controllers;

use Modules\Terms\Models\TermsModel;

class TermsAPIController {
    private $model;

    public function __construct() {
        $this->model = new TermsModel();
    }

    public function index() {
        try {
            $terms = $this->model->getAllTerms();
            echo json_encode(["status" => "success", "data" => $terms]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function create() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid payload"]);
            return;
        }
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
        try {
            $this->model->deleteTerm($num);
            echo json_encode(["status" => "success", "message" => "Term deleted"]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
