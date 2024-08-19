<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

  <?php
  include "extras/header.php";
  include "extras/nav_index.php";
  ?>

  <main id="terms_conditions" class="bg-light px-5 px-lg-0 py-5 my-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <h1 class="display-5 fw-bold">Terms & Conditions</h1>
        <p class="lead">Below are our detailed, but not limited, terms and conditions, which also include our privacy policy. Please read these before making a reservation. If you have any further questions or requests, please don't hesitate to contact us. In addition, when making a reservation, an email address is required because that will be used for our confirmation email.</p>
        <hr class="my-3">
        <div class='col-lg-3 mb-4 mb-lg-0'>
          <?php include "sub_dbtct.php"; ?>
        </div>
        <div class='col-lg-8'>
          <?php include "sub_dbtcd.php"; ?>
        </div>
      </div>
    </div>
  </main>

  <?php include "extras/copyright.php" ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>