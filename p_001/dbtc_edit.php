<?php

require("dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tcNum = $_POST['tcNum'];
  $tcTitle = $_POST['tcTitle'];
  $tcDescription = $_POST['tcDescription'];

  $tcValidate = "SELECT tc_num FROM terms_conditions WHERE tc_num = ?";
  $tcvQuery = $dbConnect->prepare($tcValidate);
  $tcvQuery->bind_param("i", $tcNum);
  $tcvQuery->execute();
  $tcvResults = $tcvQuery->get_result();

  if ($tcvResults->num_rows >= 1) {
    $notAdded = True;
    include "atc_edit.php";
    exit();
  } else {
    $tcEdit = "INSERT INTO terms_conditions VALUES (?, ?, ?)";
    $editQuery = $dbConnect->prepare($tcEdit);
    $editQuery->bind_param("iss", $tcNum, $tcTitle, $tcDescription);
    $editQuery->execute();

    $added = True;
    include "atc_edit.php";
    exit();
  }
};

$dbConnect->close();
?>