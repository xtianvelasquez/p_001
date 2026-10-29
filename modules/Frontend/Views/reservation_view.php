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
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    .pass-card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
      overflow: hidden;
    }
    .pass-header {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      color: #ffffff;
      padding: 1.5rem;
    }
    .pass-code-badge {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 0.4rem 0.9rem;
      border-radius: 999px;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: 0.05em;
    }
    .detail-item {
      padding: 0.75rem 0;
      border-bottom: 1px dashed #e2e8f0;
    }
    .detail-item:last-child {
      border-bottom: none;
    }
    @media print {
      body {
        background: #ffffff !important;
      }
      .no-print {
        display: none !important;
      }
      .pass-card {
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
        <div class="col-12 col-md-8 col-lg-6">

          <?php if ($reservation): ?>
            <?php 
              $status = strtolower($reservation['status'] ?? 'confirmed');
              $statusClass = 'status-' . $status;
              $formattedDate = date('F j, Y (l)', strtotime($reservation['reservation_date']));
              $formattedTime = date('g:i A', strtotime($reservation['reservation_time']));
            ?>
            <div class="pass-card">
              <!-- Header -->
              <div class="pass-header text-center">
                <p class="section-kicker text-warning mb-1">Official Reservation Pass</p>
                <h1 class="h4 fw-bold mb-3">BenHub Restaurant</h1>
                <div class="d-inline-flex align-items-center pass-code-badge">
                  <i class="bi bi-qr-code-scan me-2"></i>
                  <span><?= escape($reservation['confirmation_code']) ?></span>
                </div>
              </div>

              <!-- Pass Body -->
              <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-secondary small text-uppercase fw-bold">Booking Status</span>
                  <span class="status-pill <?= $statusClass ?> fs-6 px-3 py-1"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                </div>

                <div class="detail-item">
                  <div class="small text-secondary">Guest Name</div>
                  <div class="fw-bold fs-5"><?= escape($reservation['first_name'] . ' ' . $reservation['last_name']) ?></div>
                </div>

                <div class="row">
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Contact Number</div>
                    <div class="fw-semibold"><?= escape($reservation['contact_num']) ?></div>
                  </div>
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Email Address</div>
                    <div class="fw-semibold text-truncate"><?= escape($reservation['email_add']) ?></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Date</div>
                    <div class="fw-bold text-primary"><?= escape($formattedDate) ?></div>
                  </div>
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Time Slot</div>
                    <div class="fw-bold text-primary"><?= escape($formattedTime) ?></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Table & Floor</div>
                    <div class="fw-semibold"><?= escape($reservation['reservation_table']) ?> <span class="badge bg-secondary"><?= escape($reservation['reservation_floor']) ?></span></div>
                  </div>
                  <div class="col-6 detail-item">
                    <div class="small text-secondary">Party Size</div>
                    <div class="fw-semibold"><?= escape($reservation['num_guest']) ?> Guest<?= (int)$reservation['num_guest'] > 1 ? 's' : '' ?></div>
                  </div>
                </div>

                <?php if (!empty($reservation['occasion'])): ?>
                  <div class="detail-item">
                    <div class="small text-secondary">Occasion</div>
                    <div class="fw-semibold"><?= escape($reservation['occasion']) ?></div>
                  </div>
                <?php endif; ?>

                <?php if (!empty($reservation['special_request'])): ?>
                  <div class="detail-item">
                    <div class="small text-secondary">Special Requests</div>
                    <div class="fw-semibold text-secondary fst-italic"><?= escape($reservation['special_request']) ?></div>
                  </div>
                <?php endif; ?>

                <!-- Mini QR & Scan Verification Proof -->
                <div class="bg-light border rounded p-3 text-center mt-4">
                  <div id="qrcodeView" class="d-flex justify-content-center mb-2"></div>
                  <div class="small text-secondary">Present this pass upon arrival at BenHub.</div>
                  <div class="small text-muted font-monospace mt-1">ID: #<?= escape($reservation['reservation_id']) ?></div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mt-4 no-print">
                  <button type="button" class="btn btn-outline-secondary w-50" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Pass
                  </button>
                  <a href="/reservation" class="btn btn-accent w-50">
                    <i class="bi bi-calendar-check"></i> Book Again
                  </a>
                </div>
              </div>
            </div>

          <?php else: ?>
            <!-- Not Found State -->
            <div class="card shadow-sm border-0 p-4 p-md-5 text-center">
              <div class="text-warning display-4 mb-3">
                <i class="bi bi-exclamation-triangle"></i>
              </div>
              <h2 class="h4 fw-bold mb-2">Reservation Not Found</h2>
              <p class="text-secondary mb-4">
                <?= $code !== '' ? 'No active reservation matches code: <strong>' . escape($code) . '</strong>' : 'No reservation code was provided.' ?>
              </p>

              <!-- Lookup Form -->
              <form action="/reservation/view" method="GET" class="mb-4">
                <div class="input-group">
                  <input type="text" name="code" class="form-control" placeholder="Enter confirmation code (e.g. BH-XXXXXX)" value="<?= escape($code) ?>" required>
                  <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Search
                  </button>
                </div>
              </form>

              <div class="d-flex justify-content-center gap-2">
                <a href="/reservation" class="btn btn-accent">
                  <i class="bi bi-calendar-plus"></i> Make a Reservation
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
