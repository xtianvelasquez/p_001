<?php
$code = trim($_GET['code'] ?? '');
$reservation = null;

if ($code !== '') {
    try {
        $model = new \Modules\Reservation\Models\ReservationModel();
        $reservation = $model->getReservationByCode($code);
    } catch (\Exception $e) {
        $reservation = null;
    }
}

function escape(mixed $value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Reservation Details</title>
  <link rel="icon" type="image/png" href="/assets/images/benhub-icon.png">
  <link rel="shortcut icon" href="/assets/images/benhub-icon.png">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=2.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    @media print {
      body {
        background: #ffffff !important;
      }
      .no-print {
        display: none !important;
      }
      .bento-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
      }
    }
  </style>
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

  <!-- Top Navbar -->
  <header class="bg-white border-bottom py-2 px-3 no-print">
    <div class="container-lg d-flex align-items-center justify-content-between">
      <a href="/" class="d-inline-flex align-items-center text-decoration-none">
        <img src="/assets/images/benhub.png" alt="BenHub Logo" style="height: 30px; width: auto;">
      </a>
      <div>
        <a href="/reservation" class="btn btn-sm btn-accent me-1">
          <i class="bi bi-calendar-plus"></i> New Reservation
        </a>
        <a href="/" class="btn btn-sm btn-outline-secondary">
          <i class="bi bi-house"></i> Home
        </a>
      </div>
    </div>
  </header>

  <main class="flex-grow-1 py-4 py-md-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

          <?php if ($reservation): ?>
            <?php 
              $status = strtolower($reservation['status'] ?? 'confirmed');
              $statusClass = 'status-' . $status;
              $formattedDate = date('F j, Y (l)', strtotime($reservation['reservation_date']));
              $formattedTime = date('g:i A', strtotime($reservation['reservation_time']));
            ?>
            
            <!-- Bento Pass Container -->
            <div class="row g-3">
              <!-- Bento Card 1: Pass Header Banner -->
              <div class="col-12">
                <div class="bento-card bento-card-dark p-4 text-center">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <span class="bento-tag">
                      <i class="bi bi-patch-check-fill text-warning"></i> Official Booking Pass
                    </span>
                    <span class="status-pill <?= $statusClass ?> fs-6 px-3 py-1">
                      <?= ucfirst(str_replace('_', ' ', $status)) ?>
                    </span>
                  </div>
                  
                  <h1 class="h3 fw-bold text-white mb-2">BenHub Restaurant</h1>
                  <p class="text-light opacity-75 small mb-3">Present this digital pass upon arrival for immediate seating.</p>

                  <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-25 px-4 py-2 rounded-pill font-monospace fs-4 fw-bold text-warning">
                    <i class="bi bi-qr-code-scan me-2"></i>
                    <span><?= escape($reservation['confirmation_code']) ?></span>
                  </div>
                </div>
              </div>

              <!-- Bento Card 2: Guest & Visit Details (Col 7) -->
              <div class="col-md-7">
                <div class="bento-card p-4 h-100 d-flex flex-column justify-content-between">
                  <div>
                    <span class="section-kicker">Reservation Details</span>
                    <h3 class="h5 fw-bold text-dark mt-1 mb-3"><?= escape($reservation['first_name'] . ' ' . $reservation['last_name']) ?></h3>

                    <div class="row g-2 mb-3">
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <div class="small text-secondary">Date</div>
                          <div class="fw-bold text-dark"><?= escape($formattedDate) ?></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <div class="small text-secondary">Time Slot</div>
                          <div class="fw-bold text-dark"><?= escape($formattedTime) ?></div>
                        </div>
                      </div>
                    </div>

                    <div class="row g-2 mb-3">
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <div class="small text-secondary">Table & Level</div>
                          <div class="fw-bold text-dark"><?= escape($reservation['reservation_table']) ?></div>
                          <div class="small text-muted"><?= escape($reservation['reservation_floor']) ?></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <div class="small text-secondary">Party Size</div>
                          <div class="fw-bold text-dark"><?= escape($reservation['num_guest']) ?> Guest<?= (int)$reservation['num_guest'] > 1 ? 's' : '' ?></div>
                        </div>
                      </div>
                    </div>

                    <?php if (!empty($reservation['occasion']) || !empty($reservation['special_request'])): ?>
                      <div class="p-3 bg-light rounded-3 mb-2 small">
                        <?php if (!empty($reservation['occasion'])): ?>
                          <div><strong>Occasion:</strong> <?= escape($reservation['occasion']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($reservation['special_request'])): ?>
                          <div class="text-secondary mt-1"><em>"<?= escape($reservation['special_request']) ?>"</em></div>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="small text-muted pt-2 border-top">
                    <i class="bi bi-envelope me-1"></i> <?= escape($reservation['email_add']) ?> &nbsp;·&nbsp;
                    <i class="bi bi-phone me-1"></i> <?= escape($reservation['contact_num']) ?>
                  </div>
                </div>
              </div>

              <!-- Bento Card 3: QR Code & Verification (Col 5) -->
              <div class="col-md-5">
                <div class="bento-card p-4 h-100 d-flex flex-column justify-content-between text-center">
                  <div>
                    <span class="section-kicker">Scannable Proof</span>
                    <h4 class="h6 fw-bold mt-1 mb-3">Host Verification</h4>
                    
                    <div class="d-flex justify-content-center mb-3">
                      <div id="qrcodeView" class="p-2 bg-white border rounded-3 shadow-sm"></div>
                    </div>
                    
                    <div class="small text-secondary">
                      Scan with any smartphone camera to view live booking details.
                    </div>
                  </div>

                  <div class="pt-3 border-top no-print">
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="window.print()">
                      <i class="bi bi-printer me-1"></i> Print / Save Pass
                    </button>
                    <a href="/reservation" class="btn btn-accent btn-sm w-100">
                      <i class="bi bi-calendar-plus me-1"></i> Book Another Table
                    </a>
                  </div>
                </div>
              </div>

            </div>

          <?php else: ?>
            <!-- Not Found Bento State with Tasteful unDraw Empty Illustration -->
            <div class="bento-card p-4 p-md-5 text-center">
              <div class="mb-4 d-flex justify-content-center">
                <img src="/assets/images/illustrations/undraw_empty_search.svg" alt="Reservation Not Found" class="img-fluid" style="max-height: 200px;">
              </div>
              <h2 class="h4 fw-bold mb-2">Reservation Not Found</h2>
              <p class="text-secondary mb-4">
                <?= $code !== '' ? 'No active booking matches confirmation code: <strong>' . escape($code) . '</strong>' : 'No reservation code was provided.' ?>
              </p>

              <!-- Lookup Form -->
              <form action="/reservation/view" method="GET" class="mb-4" style="max-width: 440px; margin: 0 auto;">
                <div class="input-group">
                  <input type="text" name="code" class="form-control" placeholder="e.g. BH-XXXXXX" value="<?= escape($code) ?>" required>
                  <button class="btn btn-accent" type="submit">
                    <i class="bi bi-search me-1"></i> Search
                  </button>
                </div>
              </form>

              <div class="d-flex justify-content-center gap-2">
                <a href="/reservation" class="btn btn-outline-secondary">
                  <i class="bi bi-calendar-plus"></i> New Reservation
                </a>
                <a href="/" class="btn btn-outline-secondary">
                  <i class="bi bi-house"></i> Home
                </a>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </main>

  <footer class="mt-auto no-print">
    <?php include __DIR__ . "/extras/copyright.php"; ?>
  </footer>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script src="/assets/js/qrcode.min.js"></script>
  <?php if ($reservation): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const qrEl = document.getElementById('qrcodeView');
      if (qrEl) {
        new QRCode(qrEl, {
          text: window.location.href,
          width: 140,
          height: 140,
          colorDark: "#0f172a",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.M
        });
      }
    });
  </script>
  <?php endif; ?>
</body>
</html>
