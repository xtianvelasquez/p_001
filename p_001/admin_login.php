<?
session_start();
require "dbconnection.php";
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

  <div class="container-fluid bg-light py-3 ps-4 shadow-sm">
    <a href="index.php" target="_blank">
      <img src="images/benhub.png" alt="BenHub Logo" class="img-fluid" width="100" height="20">
    </a>
  </div>

  <div class="container-lg px-5 px-lg-0 py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <!--card image-->
          <div class="card-img-top">
            <img src="images/image1.jpg" alt="Photo by Linh Nguyen on Unplash" class="img-fluid">
          </div>
          <!--card body-->
          <div class="card-body p-5">
            <!--feedback-->
            <?php
            if (isset($invalidCredentials)) {
              echo "<div class='alert alert-danger alert-dismissible fade show mb-3'>
                    <strong>Error:</strong> Incorrect username or password.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
            }
            ?>
            <!--login form-->
            <form action="db_adlogin.php" method="post" autocomplete="off">
              <div class="row mb-4">
                <label for="adUsername">Username</label>
                <input type="text" name="adUsername" id="adUsername" maxlength="100" class="form-control" required>
              </div>
              <div class="row mb-5">
                <label for="adPassword">Password</label>
                <input type="password" name="adPassword" id="adPassword" maxlength="100" class="form-control" required>
              </div>
              <div class="row">
                <input type="submit" value="Login" class="btn btn-primary px-4">
              </div>
            </form>
            <!--login form-->
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "extras/copyright.php"; ?>

  <script src="bootstrap/js/bootstrap.min.js?v5.3"></script>
</body>

</html>