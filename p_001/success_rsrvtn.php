<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Reservation</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

  <?php
  include "extras/header.php";
  include "extras/nav_index.php";
  ?>

  <main id="reservation" class="bg-light px-5 px-lg-0 py-5 my-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-lg-8 p-4">
          <p class="lead mb-3"><strong>Thank you for your reservation!</strong> Your reservation has been successfully made. We will further notify you through our email that you will receive the day before your reserved date. Have a great time ahead.</p>
          <?php include "sub_dbsr.php"; ?>
        </div>
      </div>
    </div>
  </main>

  <?php include "extras/copyright.php" ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>