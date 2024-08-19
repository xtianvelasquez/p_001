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

  <main id="about_us" class="bg-light px-5 px-lg-0 py-5 my-5 text-center">
    <div class="container-lg">
      <div class="row justify-content-center align-items-center gap-2">
        <div class="col-lg-6 mb-3 mb-lg-0">
          <!--about us-->
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, laborum hic ipsam enim illum accusamus incidunt. Nostrum asperiores laborum consequatur doloribus tempore est nobis inventore sunt fugit assumenda totam ducimus aliquam rem magnam neque modi mollitia, architecto exercitationem recusandae. Sed voluptatum molestiae provident rerum exercitationem ab, eos dolore magni sequi consectetur quam ipsum, debitis quae tenetur aperiam similique. Eveniet, assumenda ipsam dolorem laudantium facilis, illum sed corporis blanditiis eaque saepe voluptatem unde mollitia. Ea facere ex inventore nulla itaque laboriosam!</p>

          <!--social medias-->
          <div class="text-center mt-5 mb-3 mb-lg-0">
            <div class="btn-group gap-1">
              <a href="https://facebook.com" target="_blank" class="btn btn-outline-primary btn-sm py-2 px-3 rounded-0">
                <i class="bi bi-facebook"></i>
                <p class="d-none d-md-inline">facebook</p>
              </a>
              <a href="https://instagram.com" target="_blank" class="btn btn-outline-primary btn-sm py-2 px-3">
                <i class="bi bi-instagram"></i>
                <p class="d-none d-md-inline">instagram</p>
              </a>
              <a href="https://www.threads.net/login" target="_blank" class="btn btn-outline-primary btn-sm py-2 px-3">
                <i class="bi bi-threads"></i>
                <p class="d-none d-md-inline">threads</p>
              </a>
              <a href="https://twitter.com/" target="_blank" class="btn btn-outline-primary btn-sm py-2 px-3">
                <i class="bi bi-twitter"></i>
                <p class="d-none d-md-inline">twitter</p>
              </a>
              <a href="https://www.linkedin.com/" target="_blank" class="btn btn-outline-primary btn-sm py-2 px-3 rounded-0">
                <i class="bi bi-linkedin"></i>
                <p class="d-none d-md-inline">linkedin</p>
              </a>
            </div>
          </div>

          <!--image-->
        </div>
        <div class="col-lg-4">
          <img src="images/image1.jpg" alt="Photo by Linh Nguyen on Unplash" class="img-fluid mb-2">
          <span>Photo by <a class="text-decoration-none" href="https://unsplash.com/@bylinhnguyen?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash" target="_blank">Linh Nguyen</a> on <a class="text-decoration-none" href="https://unsplash.com/photos/brown-concrete-building-fnaVlvnuG34?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash" target="_blank">Unsplash</a></span>
        </div>
      </div>
    </div>
  </main>

  <!--contact-->
  <section id="contact" class="px-5 px-lg-0 mb-5">
    <div class="container-lg">
      <div class="row justify-content-center align-items-top gap-3">
        <div class="col-md-3 text-center py-4 border border-1 border-secondary">
          <h6 class="fw-bold mb-3">Address</h6>
          <p class="mb-0">1234 Imaginary Street, Fictionville,</p>
          <p class="mb-3">Manila, Philippines</p>
          <a href="#" target="_blank" class="btn btn-outline-secondary btn-sm py-2 px-4">Location</a>
        </div>
        <div class="col-md-3 text-center py-4 border border-1 border-secondary">
          <h6 class="fw-bold mb-3">Contacts</h6>
          <a href="tel:#" class="text-dark text-decoration-none mb-3 d-block">+1 (555) 555-1234</a>
          <a href="mailto:#" class="text-dark text-decoration-none mb-0">info@example.com</a>
        </div>
        <div class="col-md-3 text-center py-4 border border-1 border-secondary">
          <h6 class="fw-bold mb-3">Hours</h6>
          <p class="mb-0">Monday - Saturday</p>
          <p>10:00 AM - 6:00 PM</p>
        </div>
      </div>
    </div>
  </section>

  <?php include "extras/copyright.php" ?>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>