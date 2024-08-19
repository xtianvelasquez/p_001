<?php

require "dbconnection.php";

if (isset($_GET['search'])) {
  $searchDate = $_GET['reservationDate'];

  if ($searchDate == "no data yet.") {
    $noData = True;
    include "admin.php";
  } else {
    $search = "SELECT reservation_date FROM reservation_info WHERE reservation_date = ?";
    $searchQuery = $dbConnect->prepare($search);
    $searchQuery->bind_param("s", $searchDate);
    $searchQuery->execute();
    $searchResult = $searchQuery->get_result();

    if ($searchResult->num_rows > 0) {
      while ($searchRow = $searchResult->fetch_assoc()) {
        header("Location: admin.php#$searchRow[reservation_date]");
      }
    } else {
      $noSearch = True;
      include "admin.php";
    }
  }
}

$dbConnect->close();
?>