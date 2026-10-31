<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub</title>
  <link rel="icon" type="image/png" href="/assets/images/benhub-icon.png">
  <link rel="shortcut icon" href="/assets/images/benhub-icon.png">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=2.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    .bento-hero-img {
      object-fit: cover;
      height: 100%;
      min-height: 280px;
      width: 100%;
      border-radius: var(--radius-bento);
      filter: brightness(0.92);
      transition: transform 0.4s ease;
    }
    .bento-hero-img-wrap:hover .bento-hero-img {
      transform: scale(1.02);
    }
  </style>
</head>
<body>
  <?php include __DIR__ . "/extras/nav_index.php"; ?>

  <main class="py-4 py-md-5">
    <div class="container-lg">
      
      <!-- BENTO GRID -->
      <div class="row g-3 g-lg-4">
        
        <!-- Bento Cell 1: Main Hero Banner (Col 8) -->
        <div class="col-lg-8">
          <div class="bento-card bento-card-dark p-4 p-md-5 h-100 d-flex flex-column justify-content-between position-relative">
            <div class="position-relative z-1">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <span class="bento-tag">
                  <i class="bi bi-patch-check-fill text-warning"></i> Table Reservations
                </span>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold small">
                  <span class="d-inline-block rounded-circle bg-success me-1" style="width:8px; height:8px;"></span> Live Availability
                </span>
              </div>
              <h1 class="display-5 fw-bold text-white mb-3">
                Reserve the right table for the right moment.
              </h1>
              <p class="lead text-light opacity-75 mb-4" style="max-width: 580px;">
                Instant table confirmation, clear floor availability across 3 levels, and contactless digital booking passes.
              </p>
            </div>
            
            <div class="position-relative z-1 d-flex flex-wrap gap-2 pt-2">
              <a href="/reservation" class="btn btn-accent btn-lg px-4 shadow-sm">
                <i class="bi bi-calendar-check me-1"></i> Book a Table
              </a>
              <a href="#about_us" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-info-circle me-1"></i> Learn More
              </a>
            </div>

            <!-- Subtle background decorative glow -->
            <div class="position-absolute end-0 bottom-0 p-5 opacity-10 pointer-events-none d-none d-md-block" style="font-size: 16rem; line-height: 0; color: #ffffff;">
              <i class="bi bi-cup-hot"></i>
            </div>
          </div>
        </div>

        <!-- Bento Cell 2: Dining Ambience Image + Overlay (Col 4) -->
        <div class="col-lg-4">
          <div class="bento-card bento-hero-img-wrap h-100 position-relative p-0 overflow-hidden" style="min-height: 320px;">
            <img src="/assets/images/image1.jpg" alt="BenHub dining space" class="bento-hero-img position-absolute top-0 start-0 w-100 h-100">
            <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(180deg, transparent 0%, rgba(15,23,42,0.92) 100%);">
              <div class="bento-tag mb-2" style="background: rgba(255,255,255,0.2); color: #fff; border-color: rgba(255,255,255,0.3);">
                <i class="bi bi-geo-alt"></i> Dining Space
              </div>
              <h3 class="h5 fw-bold mb-1 text-white">Atmosphere & Comfort</h3>
              <p class="small text-light opacity-75 mb-0">Main Dining, Lounge, and VIP private rooms.</p>
            </div>
          </div>
        </div>

        <!-- Bento Cell 3: Feature - Instant Table Booking (Col 4) -->
        <div class="col-md-6 col-lg-4">
          <div class="bento-card bento-card-hover p-4 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="bento-icon-box mb-3">
                <i class="bi bi-lightning-charge-fill"></i>
              </div>
              <span class="section-kicker">Fast & Direct</span>
              <h3 class="h5 fw-bold mt-1 mb-2">Real-Time Table Lock</h3>
              <p class="text-secondary small mb-0">
                Pick your preferred time slot and seat capacity. Tables are updated dynamically with zero double-booking conflicts.
              </p>
            </div>
            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">No registration needed</span>
              <i class="bi bi-arrow-right-circle text-warning fs-5"></i>
            </div>
          </div>
        </div>

        <!-- Bento Cell 4: Feature - Multi-Floor Seating (Col 4) -->
        <div class="col-md-6 col-lg-4">
          <div class="bento-card bento-card-hover p-4 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="bento-icon-box success mb-3">
                <i class="bi bi-grid-1x2-fill"></i>
              </div>
              <span class="section-kicker" style="color: #166534;">Flexible Layout</span>
              <h3 class="h5 fw-bold mt-1 mb-2">Multi-Floor Capacity</h3>
              <p class="text-secondary small mb-0">
                From cozy 2-seat window nooks on Floor 1 to 12-guest private function suites on Floor 3, every party size is accommodated.
              </p>
            </div>
            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">Up to 12+ guests</span>
              <span class="badge bg-light text-dark border">3 Floors</span>
            </div>
          </div>
        </div>

        <!-- Bento Cell 5: Feature - QR Pass Verification (Col 4) -->
        <div class="col-md-12 col-lg-4">
          <div class="bento-card bento-card-hover p-4 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="bento-icon-box primary mb-3">
                <i class="bi bi-qr-code-scan"></i>
              </div>
              <span class="section-kicker" style="color: #1e40af;">Smart Check-In</span>
              <h3 class="h5 fw-bold mt-1 mb-2">Digital Booking Pass</h3>
              <p class="text-secondary small mb-0">
                Receive an instant QR code pass with confirmation details right on your smartphone. Just scan on arrival for quick seating.
              </p>
            </div>
            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">Paperless & verified</span>
              <i class="bi bi-phone text-primary fs-5"></i>
            </div>
          </div>
        </div>

        <!-- Bento Cell 6: About Us Overview (Col 6) -->
        <div class="col-lg-6" id="about_us">
          <div class="bento-card p-4 p-md-5 h-100">
            <span class="bento-tag mb-3">About BenHub</span>
            <h2 class="h4 fw-bold mb-3">Designed for relaxed meals and special celebrations</h2>
            <p class="text-secondary mb-4">
              BenHub helps guests plan ahead with a seamless reservation experience and gives our team complete visibility over daily bookings. Choose your preferred schedule, share your dining needs, and arrive knowing your table is waiting for you.
            </p>
            <div class="row g-2">
              <div class="col-sm-6">
                <div class="p-3 bg-light rounded-3">
                  <div class="fw-bold text-dark"><i class="bi bi-clock-history text-warning me-2"></i>Instant Confirmation</div>
                  <div class="small text-secondary mt-1">Bookings confirmed in seconds.</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="p-3 bg-light rounded-3">
                  <div class="fw-bold text-dark"><i class="bi bi-shield-check text-success me-2"></i>Guaranteed Seating</div>
                  <div class="small text-secondary mt-1">Capacity-aware table locks.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Bento Cell 7: Operating Hours & Visit Info (Col 6) -->
        <div class="col-lg-6" id="contact">
          <div class="bento-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="bento-tag">Hours & Contacts</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">Open Today</span>
              </div>
              <div class="row g-3 mb-4">
                <div class="col-sm-6">
                  <div class="small text-secondary text-uppercase fw-bold">Operating Hours</div>
                  <div class="fw-bold fs-5 text-dark mt-1">10:00 AM – 6:00 PM</div>
                  <div class="small text-muted">Monday through Saturday</div>
                </div>
                <div class="col-sm-6">
                  <div class="small text-secondary text-uppercase fw-bold">Address</div>
                  <div class="fw-bold fs-5 text-dark mt-1">1234 Imaginary St.</div>
                  <div class="small text-muted">Fictionville, Manila, Philippines</div>
                </div>
              </div>
            </div>

            <div class="row g-2 pt-3 border-top">
              <div class="col-sm-6">
                <a href="tel:+15555551234" class="btn btn-outline-secondary w-100 text-start py-2 px-3 small">
                  <i class="bi bi-telephone text-primary me-2"></i>+1 (555) 555-1234
                </a>
              </div>
              <div class="col-sm-6">
                <a href="mailto:info@example.com" class="btn btn-outline-secondary w-100 text-start py-2 px-3 small">
                  <i class="bi bi-envelope text-warning me-2"></i>info@example.com
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- END BENTO GRID -->

    </div>
  </main>

  <?php include __DIR__ . "/extras/copyright.php" ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>
</html>
