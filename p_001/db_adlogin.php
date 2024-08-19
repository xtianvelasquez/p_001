<?php

session_start();
require("dbconnection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $adUsername = $_POST['adUsername'];
  $adPassword = $_POST['adPassword'];

  try {
    // validate credentials
    $validateCredentials = "SELECT * FROM admin_info WHERE ad_username = ? AND ad_password = ? LIMIT 1";
    $credentialsQuery = $dbConnect->prepare($validateCredentials);
    $credentialsQuery->bind_param("ss", $adUsername, $adPassword);
    $credentialsQuery->execute();
    $credentialsResult = $credentialsQuery->get_result();

    if ($credentialsResult->num_rows > 0) {
      $credentialsRow = $credentialsResult->fetch_assoc();
      $_SESSION['adUsername'] = $credentialsRow['ad_username'];
      $_SESSION['adPassword'] = $credentialsRow['ad_password'];
      $_SESSION['adName'] = $credentialsRow['ad_name'];
      header("Location: admin.php");
      exit;
    } else {
      $invalidCredentials = True;
      include "admin_login.php";
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