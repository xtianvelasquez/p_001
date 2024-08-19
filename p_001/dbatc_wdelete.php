<?php

require("dbconnection.php");

if (isset($_GET['num'])) {
  $tcNum = $_GET['num'];

  $tcNumDelete = "DELETE FROM terms_conditions WHERE tc_num = ? LIMIT 1";
  $tcdelQuery = $dbConnect->prepare($tcNumDelete);
  $tcdelQuery->bind_param("i", $tcNum);
  $tcdelQuery->execute();

  $dbConnect->close();
}

header("Location: atc_edit.php#terms_conditions.php");
?>