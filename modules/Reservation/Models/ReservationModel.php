<?php
namespace Modules\Reservation\Models;

use Core\Database;
use PDO;

class ReservationModel {
    private $db;
    private $activeStatuses = ['pending', 'confirmed', 'seated'];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createReservation($data) {
        $this->db->beginTransaction();
        try {
            // Insert Reservation Info
            $stmt = $this->db->prepare("INSERT INTO reservation_info (reservation_date, reservation_time, num_guest, reservation_floor, reservation_table, status, occasion, special_request, confirmation_code) VALUES (:date, :time, :guest, :floor, :table, :status, :occasion, :special_request, :confirmation_code) RETURNING reservation_id");
            
            $stmt->execute([
                ':date' => $data['reserveDate'],
                ':time' => $data['reserveTime'],
                ':guest' => $data['numGuest'],
                ':floor' => $data['reserveFloor'],
                ':table' => $data['reserveTable'],
                ':status' => 'confirmed',
                ':occasion' => $data['occasion'] ?? null,
                ':special_request' => $data['specialRequest'] ?? null,
                ':confirmation_code' => $data['confirmationCode']
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservation_info WHERE reservation_date = :date AND reservation_time = :time AND reservation_floor = :floor AND reservation_table = :table AND status IN ('pending', 'confirmed', 'seated')");
        $stmt->execute([
            ':date' => $date,
            ':time' => $time,
            ':floor' => $floor,
            ':table' => $table
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAllReservations() {
        $stmt = $this->db->query("SELECT r.*, c.first_name, c.last_name, c.age, c.contact_num, c.email_add FROM reservation_info r JOIN customer_info c ON r.reservation_id = c.customer_id ORDER BY r.reservation_date DESC, r.reservation_time ASC");
        return $stmt->fetchAll();
    }

    public function getAvailableTables($date, $time, $guests) {
        $stmt = $this->db->prepare("SELECT t.table_name, t.floor_name, t.capacity, t.area
            FROM restaurant_tables t
            WHERE t.is_active = TRUE
              AND t.capacity >= :guests
              AND NOT EXISTS (
                SELECT 1
                FROM reservation_info r
                WHERE r.reservation_date = :date
                  AND r.reservation_time = :time
                  AND r.reservation_floor = t.floor_name
                  AND r.reservation_table = t.table_name
                  AND r.status IN ('pending', 'confirmed', 'seated')
              )
            ORDER BY t.capacity ASC, t.floor_name ASC, t.table_name ASC");
        $stmt->execute([
            ':date' => $date,
            ':time' => $time,
            ':guests' => $guests
        ]);
        return $stmt->fetchAll();
    }

    public function getTableInfo($floor, $table) {
        $stmt = $this->db->prepare("SELECT * FROM restaurant_tables WHERE floor_name = :floor AND table_name = :table");
        $stmt->execute([
            ':floor' => $floor,
            ':table' => $table
        ]);
        return $stmt->fetch() ?: null;
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE reservation_info SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE reservation_id = :id");
        $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
        return $stmt->rowCount() > 0;
    }

    public function deleteReservation($id) {
        $stmt = $this->db->prepare("DELETE FROM reservation_info WHERE reservation_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
