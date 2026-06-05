<?php
namespace Modules\Terms\Models;

use Core\Database;

class TermsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllTerms() {
        $stmt = $this->db->query("SELECT * FROM terms_conditions ORDER BY tc_num ASC");
        return $stmt->fetchAll();
    }

    public function createTerm($num, $title, $desc) {
        $stmt = $this->db->prepare("INSERT INTO terms_conditions (tc_num, tc_title, tc_description) VALUES (:num, :title, :desc)");
        return $stmt->execute([
            ':num' => $num,
            ':title' => $title,
            ':desc' => $desc
        ]);
    }

    public function deleteTerm($num) {
        $stmt = $this->db->prepare("DELETE FROM terms_conditions WHERE tc_num = :num");
        return $stmt->execute([':num' => $num]);
    }
}
