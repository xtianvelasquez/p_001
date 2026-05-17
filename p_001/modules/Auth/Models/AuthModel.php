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
        $stmt = $this->db->prepare("SELECT * FROM admin_info WHERE ad_username = :user AND ad_password = :pass");
        $stmt->execute([
            ':user' => $username,
            ':pass' => $password
        ]);
        return $stmt->fetch();
    }
}
