<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub</title>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <?php include __DIR__ . "/extras/nav_index.php"; ?>

  <header class="hero-band d-flex align-items-center">
    <div class="container-lg py-5">
      <div class="row">
        <div class="col-lg-7">
          <img src="/assets/images/benhub.png" alt="BenHub Logo" class="brand-mark p-2 mb-4">
          <p class="section-kicker mb-2">Restaurant Reservations</p>
          <h1 class="display-4 fw-bold mb-3">BenHub</h1>
          <p class="lead mb-4">Reserve the right table for the right moment with clear availability, instant confirmation, and a smoother dining experience.</p>
          <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="/reservation" class="btn btn-accent btn-lg px-4">
              <i class="bi bi-calendar-check"></i> Reserve a table
            </a>
            <a href="#contact" class="btn btn-outline-light btn-lg px-4">
              <i class="bi bi-geo-alt"></i> Visit us
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main id="about_us" class="py-5">
    <div class="container-lg">
      <div class="row justify-content-center align-items-center g-4">
        <div class="col-lg-6">
          <p class="section-kicker mb-2">About BenHub</p>
          <h2 class="h3 fw-bold mb-3">Designed for relaxed meals and special celebrations</h2>
          <p class="text-secondary">BenHub helps guests plan ahead with a simple reservation experience and gives the restaurant team a clearer view of daily bookings. Choose your preferred schedule, share your dining needs, and arrive knowing your table is ready.</p>
          <div class="row g-3 mt-2">
            <div class="col-sm-4">
              <div class="stat-tile h-100">
                <i class="bi bi-clock text-warning fs-4"></i>
                <div class="fw-bold mt-2">Fast booking</div>
                <div class="small text-secondary">Instant table request flow</div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="stat-tile h-100">
                <i class="bi bi-people text-warning fs-4"></i>
                <div class="fw-bold mt-2">Guest-ready</div>
                <div class="small text-secondary">Capacity-aware seating</div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="stat-tile h-100">
                <i class="bi bi-shield-check text-warning fs-4"></i>
                <div class="fw-bold mt-2">Confirmed</div>
                <div class="small text-secondary">Code-based booking proof</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <img src="/assets/images/image1.jpg" alt="BenHub dining space" class="img-fluid rounded-2 shadow">
        </div>
      </div>
    </div>
  </main>

  <section id="contact" class="pb-5">
    <div class="container-lg">
      <div class="content-panel p-4 p-md-5">
        <div class="row g-4">
          <div class="col-md-4">
            <p class="section-kicker mb-2">Address</p>
            <p class="mb-1 fw-bold">1234 Imaginary Street</p>
            <p class="text-secondary mb-3">Fictionville, Manila, Philippines</p>
            <a href="#" target="_blank" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-map"></i> Location
            </a>
          </div>
          <div class="col-md-4">
            <p class="section-kicker mb-2">Contacts</p>
            <a href="tel:#" class="text-dark text-decoration-none d-block mb-2">+1 (555) 555-1234</a>
            <a href="mailto:#" class="text-dark text-decoration-none d-block">info@example.com</a>
          </div>
          <div class="col-md-4">
            <p class="section-kicker mb-2">Hours</p>
            <p class="mb-1 fw-bold">Monday - Saturday</p>
            <p class="text-secondary mb-0">10:00 AM - 6:00 PM</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . "/extras/copyright.php" ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>
</html>
