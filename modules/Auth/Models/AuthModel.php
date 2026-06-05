<?php
namespace Modules\Auth\Models;

use Core\Database;
use PDO;

class AuthModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin_info WHERE ad_username = :user");
        $stmt->execute([
            ':user' => $username
        ]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['ad_password'])) {
            return $user;
        }
        return false;
    }
}
