<?php
namespace Modules\Auth\Controllers;

use Modules\Auth\Models\AuthModel;

class AuthController {
    private $model;

    public function __construct() {
        $this->model = new AuthModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data || !isset($data['username']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid credentials payload"]);
            return;
        }

        $admin = $this->model->login($data['username'], $data['password']);

        if ($admin) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['ad_username'];
            
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
        }
    }

    public function logout() {
        header('Content-Type: application/json');
        session_destroy();
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Logged out successfully"]);
    }
}
