<?php
session_start();
?>

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

  <div class="container-fluid bg-light py-3 ps-4 mb-5 shadow-sm">
    <h5 class="text-start"><i class="bi bi-person-circle"></i>
      <?php if (isset($_SESSION['adName'])) {
        echo $_SESSION['adName'];
      }
      ?>
    </h5>
  </div>

  <?php include "extras/nav_admin.php"; ?>

  <main id="reservation_lists" class="bg-light py-5 my-5">
    <div class="container-lg">
      <!--search date-->
      <div class="row justify-content-center">
        <div class="col-md-4 px-5 px-md-0 mb-3">
          <form action="db_search.php" method="get">
            <div class="input-group">
              <span class="input-group-text">Search date</span>
              <?php include "db_dateoptions.php"; ?>
              <input type="submit" name="search" value="search" class="btn btn-primary btn-sm">
            </div>
          </form>
        </div>
      </div>
      <!--search date-->
      <div class="row justify-content-center">
        <div class="col-md-8 px-5 px-md-0">
          <!--feedback-->
          <?php
          if (isset($noSearch)) {
            echo "<div class='alert alert-danger alert-dismissible fade show mb-3'>
                    <strong>No result:</strong> The date you entered has no reservations.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
          } else if (isset($noData)) {
            echo "<div class='alert alert-danger alert-dismissible fade show mb-3'>
                    <strong>Error:</strong> No data yet.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
          }
          ?>
          <!--feedback-->
          <div class="table-responsive-sm mt-4">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Floor</th>
                  <th>Table</th>
                  <th>Guest/s</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!--table body-->
                <?php include "db_rdatas.php"; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "extras/copyright.php"; ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>