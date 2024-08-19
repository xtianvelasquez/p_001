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

  <div class="container-fluid bg-light py-3 ps-4 mb-5 shadow-sm">
    <h5 class="text-start"><i class="bi bi-person-circle"></i>
      <?php if (isset($_SESSION['adName'])) {
        echo $_SESSION['adName'];
      }
      ?>
    </h5>
  </div>

  <?php include "extras/nav_admin.php"; ?>

  <section id="tc_edit" class="bg-light mt-5">
    <div class="container-lg px-5 px-lg-5 py-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 p-4 border border-1 border-secondary">

          <?php
          if (isset($notAdded)) {
            echo "<div class='alert alert-danger alert-dismissible fade show mb-3'>
                      The entered number for terms and conditions already exists.
                      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>";
          } elseif (isset($added)) {
            echo "<div class='alert alert-primary alert-dismissible fade show mb-3'>    
                      The term and condition entered were successfully added.
                      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>";
          }
          ?>

          <form action="dbtc_edit.php" method="post">
            <div class="row mb-4">
              <div class="col-auto">
                <label for="tcNum">Number</label>
                <input type="number" name="tcNum" id="tcNum" min="1" max="100" class="form-control" required>
              </div>
              <div class="col">
                <label for="tcTitle">Title</label>
                <input type="text" name="tcTitle" id="tcTitle" class="form-control" required>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col">
                <label for="tcDescription">Description</label>
                <textarea name="tcDescription" id="tcDescription" minlength="1" maxlength="1000" class="form-control" required></textarea>
              </div>
            </div>
            <div class="text-center">
              <input type="submit" name="enter" value="Add" class="btn btn-primary py-2 px-5">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section id="tc">
    <div class="container-lg px-5 px-lg-0 my-5">
      <div class="row justify-content-center">
        <h1 class="display-5 fw-bold">Terms & Conditions</h1>
        <p class="lead">Below are our detailed, but not limited, terms and conditions, which also include our privacy policy. Please read these before making a reservation. If you have any further questions or requests, please don't hesitate to contact us. In addition, when making a reservation, an email address is required because that will be used for our confirmation email.</p>
        <hr class="my-3">
        <div class="col-lg-3 mb-3 mb-lg-0">
          <?php include "sub_dbtct.php"; ?>
        </div>
        <div class="col-lg-8">
          <?php include "atc_wdelete.php"; ?>
        </div>
      </div>
    </div>
  </section>

  <?php include "extras/copyright.php"; ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>