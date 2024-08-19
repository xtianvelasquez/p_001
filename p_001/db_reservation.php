<?php

require("dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserveDate = $_POST['reserveDate'];
    $reserveTime = $_POST['reserveTime'];
    $numGuest = $_POST['numGuest'];
    $reserveFloor = $_POST['reserveFloor'];
    $reserveTable = $_POST['reserveTable'];

    try {
        // Validate reservation
        $validateReservation = "SELECT reservation_table FROM reservation_info WHERE reservation_date = ? AND reservation_time = ? AND reservation_floor = ? AND reservation_table = ?";
        $query1 = $dbConnect->prepare($validateReservation);
        $query1->bind_param("ssss", $reserveDate, $reserveTime, $reserveFloor, $reserveTable);
        $query1->execute();
        $query1Result = $query1->get_result();

        if ($query1Result->num_rows >= 1) {
            $unsuccessReservation = true;
            include "reservation.php";
        } else {
            // Insert reservation info
            $reservationInfo = "INSERT INTO reservation_info(reservation_date, reservation_time, num_guest, reservation_floor, reservation_table) VALUES (?, ?, ?, ?, ?)";
            $query2 = $dbConnect->prepare($reservationInfo);
            $query2->bind_param("ssiss", $reserveDate, $reserveTime, $numGuest, $reserveFloor, $reserveTable);
            $query2->execute();

            $customerId = $dbConnect->insert_id;
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $age = $_POST['age'];
            $contactNum = "+63" . $_POST['contactNum'];
            $emailAdd = $_POST['emailAdd'];

            // Insert customer info
            $customerInfo = "INSERT INTO customer_info(customer_id, first_name, last_name, age, contact_num, email_add) VALUES (?, ?, ?, ?, ?, ?)";
            $query3 = $dbConnect->prepare($customerInfo);
            $query3->bind_param("ississ", $customerId, $firstName, $lastName, $age, $contactNum, $emailAdd);
            $query3->execute();

            header("Location: success_rsrvtn.php?rid=$customerId");
            exit;
        }
    } catch (Exception $e) {
        // Handle the exception
        echo "Error: " . $e->getMessage();
    } finally {
        // Close database connection
        if ($dbConnect->ping()) {
            $dbConnect->close();
        }
    }
}
?>