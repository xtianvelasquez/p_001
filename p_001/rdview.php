<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Administration</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

  <div class="container-fluid bg-light py-3 ps-4 mb-5 shadow">
    <h5 class="text-start"><i class="bi bi-person-circle"></i>
      <?php echo $_SESSION['adName']; ?>
    </h5>
  </div>

  <div class="container-lg mb-5">
    <div class="row justify-content-center">
      <div class="col-6">
        <?php

        require("dbconnection.php");

        if (isset($_GET['id'])) {
          $toView = $_GET['id'];

          $view = "SELECT * FROM customer_info WHERE customer_id = ?";
          $queryView = $dbConnect->prepare($view);
          $queryView->bind_param("i", $toView);
          $queryView->execute();
          $viewResults = $queryView->get_result();

          if ($viewResults->num_rows > 0) {
            while ($viewRow = $viewResults->fetch_assoc()) {
              echo "<div class='table-responsive-sm'>
              <table class='table table-bordered'>
              <tr>
                <th>ID</th>
                <td>$viewRow[customer_id]</td>
              </tr>
              <tr>
                <th>First Name</th>
                <td>$viewRow[first_name]</td>
              </tr>
              <tr>
                <th>Last Name</th>
                <td>$viewRow[last_name]</td>
              </tr>
              <tr>
                <th>Age</th>
                <td>$viewRow[age]</td>
              </tr>
              <tr>
                <th>Contact Number</th>
                <td>$viewRow[contact_num]</td>
              </tr>
              <tr>
                <th>Email Address</th>
                <td>$viewRow[email_add]</td>
              </tr>
              </table>
          </div>
            <div class='row g-1 text-center'>
              <a href='mailto:$viewRow[email_add]' class='btn btn-primary rounded-0'>email</a>
              <a href='tel:$viewRow[contact_num]' class='btn btn-primary rounded-0'>call</a>
              <a href='admin.php#reservation_lists' class='btn btn-secondary rounded-0'>back</a>
            </div>";
            }
          }
        }

        $dbConnect->close();

        ?>
      </div>
    </div>
  </div>

  <?php include "extras/copyright.php"; ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>