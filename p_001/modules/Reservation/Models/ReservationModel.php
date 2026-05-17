<?php
namespace Modules\Reservation\Models;

use Core\Database;
use PDO;

class ReservationModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createReservation($data) {
        $this->db->beginTransaction();
        try {
            // Insert Reservation Info
            $stmt = $this->db->prepare("INSERT INTO reservation_info (reservation_date, reservation_time, num_guest, reservation_floor, reservation_table) VALUES (:date, :time, :guest, :floor, :table) RETURNING reservation_id");
            
            $stmt->execute([
                ':date' => $data['reserveDate'],
                ':time' => $data['reserveTime'],
                ':guest' => $data['numGuest'],
                ':floor' => $data['reserveFloor'],
                ':table' => $data['reserveTable']
            ]);
            
            $reservationId = $stmt->fetchColumn();

            // Insert Customer Info
            $stmt2 = $this->db->prepare("INSERT INTO customer_info (customer_id, first_name, last_name, age, contact_num, email_add) VALUES (:id, :fname, :lname, :age, :contact, :email)");
            $stmt2->execute([
                ':id' => $reservationId,
                ':fname' => $data['firstName'],
                ':lname' => $data['lastName'],
                ':age' => $data['age'],
                ':contact' => $data['contactNum'],
                ':email' => $data['emailAdd']
            ]);

            $this->db->commit();
            return $reservationId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function checkAvailability($date, $time, $floor, $table) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservation_info WHERE reservation_date = :date AND reservation_time = :time AND reservation_floor = :floor AND reservation_table = :table");
        $stmt->execute([
            ':date' => $date,
            ':time' => $time,
            ':floor' => $floor,
            ':table' => $table
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAllReservations() {
        $stmt = $this->db->query("SELECT r.*, c.first_name, c.last_name, c.age, c.contact_num, c.email_add FROM reservation_info r JOIN customer_info c ON r.reservation_id = c.customer_id ORDER BY r.reservation_date DESC");
        return $stmt->fetchAll();
    }

    public function deleteReservation($id) {
        $stmt = $this->db->prepare("DELETE FROM reservation_info WHERE reservation_id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
