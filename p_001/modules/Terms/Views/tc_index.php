<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Terms and Conditions</title>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

  <?php
  include __DIR__ . "/../../Frontend/Views/extras/header.php";
  include __DIR__ . "/../../Frontend/Views/extras/nav_index.php";
  ?>

  <main id="terms_conditions" class="bg-light px-5 px-lg-0 py-5 my-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <h1 class="display-5 fw-bold">Terms & Conditions</h1>
        <p class="lead">Below are our detailed, but not limited, terms and conditions, which also include our privacy policy. Please read these before making a reservation. If you have any further questions or requests, please don't hesitate to contact us. In addition, when making a reservation, an email address is required because that will be used for our confirmation email.</p>
        <hr class="my-3">
        <div class="col-lg-3 mb-4 mb-lg-0" id="tc_titles">
          <!-- Titles loaded via JS -->
          Loading...
        </div>
        <div class="col-lg-8" id="tc_descriptions">
          <!-- Descriptions loaded via JS -->
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php" ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    fetch('/api/terms')
      .then(response => response.json())
      .then(res => {
        if (res.status === 'success') {
          let titlesHtml = '';
          let descriptionsHtml = '';
          
          res.data.forEach(term => {
            titlesHtml += `<h6 class="fw-bold mb-3">${term.tc_num}. ${term.tc_title}</h6>`;
            descriptionsHtml += `
              <div class="mb-4">
                <h6 class="fw-bold">${term.tc_num}. ${term.tc_title}</h6>
                <p class="text-secondary">${term.tc_description}</p>
              </div>`;
          });
          
          document.getElementById('tc_titles').innerHTML = titlesHtml;
          document.getElementById('tc_descriptions').innerHTML = descriptionsHtml;
        }
      });
  </script>
</body>
</html>
