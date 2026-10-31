<?php
$settingsModel = new \Modules\Reservation\Models\SettingsModel();
$siteSettings = $settingsModel->getAllSettings();
$activeFloors = $settingsModel->getActiveFloorsSummary();

$restName = htmlspecialchars($siteSettings['restaurant_name'] ?? 'BenHub', ENT_QUOTES, 'UTF-8');
$tagline = htmlspecialchars($siteSettings['tagline'] ?? 'Reserve the right table for the right moment with clear availability, instant confirmation, and a smoother dining experience.', ENT_QUOTES, 'UTF-8');
$operatingDays = htmlspecialchars($siteSettings['operating_days'] ?? 'Monday - Saturday', ENT_QUOTES, 'UTF-8');
$openingTime = htmlspecialchars($siteSettings['opening_time'] ?? '10:00 AM', ENT_QUOTES, 'UTF-8');
$closingTime = htmlspecialchars($siteSettings['closing_time'] ?? '6:00 PM', ENT_QUOTES, 'UTF-8');
$isOpenToday = ($siteSettings['is_open_today'] ?? 'true') === 'true';
$phoneNumber = htmlspecialchars($siteSettings['phone_number'] ?? '+1 (555) 555-1234', ENT_QUOTES, 'UTF-8');
$phoneClean = preg_replace('/[^\d\+]/', '', $phoneNumber);
$emailAddress = htmlspecialchars($siteSettings['email_address'] ?? 'info@example.com', ENT_QUOTES, 'UTF-8');
$streetAddress = htmlspecialchars($siteSettings['street_address'] ?? '1234 Imaginary Street', ENT_QUOTES, 'UTF-8');
$cityAddress = htmlspecialchars($siteSettings['city_address'] ?? 'Fictionville, Manila, Philippines', ENT_QUOTES, 'UTF-8');
$mapUrl = htmlspecialchars($siteSettings['map_url'] ?? '#', ENT_QUOTES, 'UTF-8');

$floorsCount = count($activeFloors);
$floorsLabel = $floorsCount > 0 ? ($floorsCount . ' Floor' . ($floorsCount > 1 ? 's' : '')) : 'Multi-Level';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $restName ?> - Restaurant Reservations</title>
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
          <div class="bento-card bento-card-dark p-4 p-md-5 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden">
            <div class="position-relative z-1">
              <div class="d-flex align-items-center gap-2 mb-3">
                <span class="bento-tag">
                  <i class="bi bi-patch-check-fill text-warning"></i> Table Reservations
                </span>
                <?php if ($isOpenToday): ?>
                  <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold small">
                    <span class="d-inline-block rounded-circle bg-success me-1" style="width:8px; height:8px;"></span> Open Today
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-semibold small">
                    <i class="bi bi-door-closed me-1"></i> Closed Today
                  </span>
                <?php endif; ?>
              </div>
              <h1 class="display-6 fw-bold text-white mb-3">
                Reserve the right table for the right moment.
              </h1>
              <p class="lead text-light opacity-75 mb-4 fs-6" style="max-width: 580px;">
                <?= $tagline ?>
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
          </div>
        </div>

        <!-- Bento Cell 2: Dining Ambience Image + Overlay (Col 4) -->
        <div class="col-lg-4">
          <div class="bento-card bento-hero-img-wrap h-100 position-relative p-0 overflow-hidden" style="min-height: 300px;">
            <img src="/assets/images/image1.jpg" alt="<?= $restName ?> dining space" class="bento-hero-img position-absolute top-0 start-0 w-100 h-100">
            <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(180deg, transparent 0%, rgba(15,23,42,0.92) 100%);">
              <div class="bento-tag mb-2" style="background: rgba(255,255,255,0.2); color: #fff; border-color: rgba(255,255,255,0.3);">
                <i class="bi bi-geo-alt"></i> Dining Space
              </div>
              <h3 class="h5 fw-bold mb-1 text-white">Atmosphere & Comfort</h3>
              <p class="small text-light opacity-75 mb-0"><?= $floorsLabel ?> across distinct dining ambiances.</p>
            </div>
          </div>
        </div>

        <!-- Bento Cell 3: Feature - Instant Table Booking (Col 4) -->
        <div class="col-md-6 col-lg-4">
          <div class="bento-card bento-card-hover p-4 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="bento-icon-box mb-3">
                <i class="bi bi-clock-history"></i>
              </div>
              <span class="section-kicker">Fast & Direct</span>
              <h3 class="h5 fw-bold mt-1 mb-2">Real-Time Table Lock</h3>
              <p class="text-secondary small mb-0">
                Pick your preferred time slot and seat capacity. Tables are updated dynamically with zero double-booking conflicts.
              </p>
            </div>
            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">No registration needed</span>
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
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
              <h3 class="h5 fw-bold mt-1 mb-2">Multi-Floor Seating</h3>
              <p class="text-secondary small mb-0">
                Spanning <?= htmlspecialchars(implode(', ', $activeFloors) ?: 'all floors') ?>, catering to couples, families, and private functions.
              </p>
            </div>
            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
              <span class="text-muted small">Available Levels</span>
              <span class="badge bg-light text-dark border"><?= $floorsLabel ?></span>
            </div>
          </div>
        </div>

        <!-- Bento Cell 5: Feature - QR Pass (Col 4) -->
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
            <span class="bento-tag mb-3">About <?= $restName ?></span>
            <h2 class="h4 fw-bold mb-3">Designed for relaxed meals and special celebrations</h2>
            <p class="text-secondary mb-4">
              <?= $restName ?> helps guests plan ahead with a seamless reservation experience and gives our team complete visibility over daily bookings. Choose your preferred schedule, share your dining needs, and arrive knowing your table is waiting for you.
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

        <!-- Bento Cell 7: Operating Hours & Visit Info (Col 6) Dynamic -->
        <div class="col-lg-6" id="contact">
          <div class="bento-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="bento-tag">Hours & Contacts</span>
                <?php if ($isOpenToday): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">Open Today</span>
                <?php else: ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">Closed Today</span>
                <?php endif; ?>
              </div>
              <div class="row g-3 mb-4">
                <div class="col-sm-6">
                  <div class="small text-secondary text-uppercase fw-bold">Operating Hours</div>
                  <div class="fw-bold fs-5 text-dark mt-1"><?= $openingTime ?> – <?= $closingTime ?></div>
                  <div class="small text-muted"><?= $operatingDays ?></div>
                </div>
                <div class="col-sm-6">
                  <div class="small text-secondary text-uppercase fw-bold">Address</div>
                  <div class="fw-bold fs-5 text-dark mt-1"><?= $streetAddress ?></div>
                  <div class="small text-muted"><?= $cityAddress ?></div>
                </div>
              </div>
            </div>

            <div class="row g-2 pt-3 border-top">
              <div class="col-sm-6">
                <a href="tel:<?= $phoneClean ?>" class="btn btn-outline-secondary w-100 text-start py-2 px-3 small">
                  <i class="bi bi-telephone text-primary me-2"></i><?= $phoneNumber ?>
                </a>
              </div>
              <div class="col-sm-6">
                <a href="mailto:<?= $emailAddress ?>" class="btn btn-outline-secondary w-100 text-start py-2 px-3 small text-truncate">
                  <i class="bi bi-envelope text-warning me-2"></i><?= $emailAddress ?>
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
