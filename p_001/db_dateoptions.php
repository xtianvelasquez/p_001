<?php

require "dbconnection.php";

$reservationDates = "SELECT DISTINCT(reservation_date) FROM reservation_info ORDER BY reservation_date ASC";
$datesQuery = $dbConnect->prepare($reservationDates);
$datesQuery->execute();
$dateResults = $datesQuery->get_result();

if ($dateResults->num_rows > 0) {
    echo "<select name='reservationDate' id='reservationDate' class='form-select'>";
    while ($dateOptions = $dateResults->fetch_assoc()) {
        echo "<option value='$dateOptions[reservation_date]'>$dateOptions[reservation_date]</option>";
    }
    echo "</select>";
} else {
    echo "<select name='reservationDate' id='reservationDate' class='form-select d-inline' required>
          <option value='no data'>no data yet.</option>
          </select>";
}

$dbConnect->close();
?>