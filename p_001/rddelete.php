<?php

require("dbconnection.php");

if (isset($_GET['id'])) {
  $toDelete = $_GET['id'];

  $delete = "DELETE FROM reservation_info WHERE reservation_id = ?";
  $queryDelete = $dbConnect->prepare($delete);
  $queryDelete->bind_param("i", $toDelete);
  $queryDelete->execute();

  $dbConnect->close();
}

header("Location: admin.php");
?>