<?php
$settingsModel = new \Modules\Reservation\Models\SettingsModel();
$siteSettings = $settingsModel->getAllSettings();
$activeFloors = $settingsModel->getActiveFloorsSummary();

$restName = htmlspecialchars($siteSettings['restaurant_name'] ?? 'BenHub', ENT_QUOTES, 'UTF-8');
$openingTime = htmlspecialchars($siteSettings['opening_time'] ?? '10:00 AM', ENT_QUOTES, 'UTF-8');
$closingTime = htmlspecialchars($siteSettings['closing_time'] ?? '6:00 PM', ENT_QUOTES, 'UTF-8');
$phoneNumber = htmlspecialchars($siteSettings['phone_number'] ?? '+1 (555) 555-1234', ENT_QUOTES, 'UTF-8');
$phoneClean = preg_replace('/[^\d\+]/', '', $phoneNumber);

$floorsCount = count($activeFloors);
$floorsLabel = $floorsCount > 0 ? ($floorsCount . ' Floor' . ($floorsCount > 1 ? 's' : '')) : 'all levels';

$timeSlots = $settingsModel->generateTimeSlots($siteSettings['opening_time'] ?? null, $siteSettings['closing_time'] ?? null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $restName ?>: Reservation</title>
  <link rel="icon" type="image/png" href="/assets/images/benhub-icon.png">
  <link rel="shortcut icon" href="/assets/images/benhub-icon.png">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=2.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <?php
  include __DIR__ . "/extras/header.php";
  include __DIR__ . "/extras/nav_index.php";
  ?>

  <main id="reservation" class="py-4 py-md-5">
    <div class="container-lg">
      
      <!-- Top Title Bento Header -->
      <div class="bento-card bento-card-dark p-4 p-md-5 mb-4 position-relative">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 position-relative z-1">
          <div>
            <span class="bento-tag mb-2">
              <i class="bi bi-calendar2-week"></i> Direct Dining Reservation
            </span>
            <h1 class="h2 fw-bold text-white mb-2">Book a table with confidence</h1>
            <p class="text-light opacity-75 mb-0" style="max-width: 600px;">
              Select your schedule, review real-time seating availability across <?= $floorsLabel ?>, and secure your dining spot.
            </p>
          </div>
          <div class="text-md-end">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold">
              <i class="bi bi-clock-history text-warning me-1"></i> <?= $openingTime ?> – <?= $closingTime ?>
            </span>
          </div>
        </div>
      </div>

      <div id="feedbackMessage"></div>

      <!-- Bento Split Grid: Form + Live Summary Pass -->
      <div class="row g-3 g-lg-4">
        
        <!-- Main Form Column (8 cols) -->
        <div class="col-lg-8">
          <form id="reservationForm" autocomplete="off">
            
            <!-- Step 1 Bento Card: Visit Details -->
            <div class="bento-card p-4 p-md-4 mb-3">
              <div class="d-flex align-items-center gap-2 mb-3">
                <div class="bento-icon-box" style="width:36px; height:36px; font-size:1.1rem;">
                  <i class="bi bi-1-circle-fill"></i>
                </div>
                <div>
                  <span class="section-kicker">Step 1</span>
                  <h2 class="h6 fw-bold mb-0">Choose Visit Schedule</h2>
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-4">
                  <label for="reserveDate" class="form-label small fw-semibold text-secondary">Date *</label>
                  <input type="date" name="reserveDate" id="reserveDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                  <label for="reserveTime" class="form-label small fw-semibold text-secondary">Time Slot *</label>
                  <select name="reserveTime" id="reserveTime" class="form-select" required>
                    <?php if (!empty($timeSlots)): ?>
                      <?php foreach ($timeSlots as $slot): ?>
                        <option value="<?= htmlspecialchars($slot, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($slot, ENT_QUOTES, 'UTF-8') ?></option>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <option value="10:00 AM">10:00 AM</option>
                      <option value="12:00 PM">12:00 PM</option>
                      <option value="2:00 PM">2:00 PM</option>
                      <option value="4:00 PM">4:00 PM</option>
                      <option value="6:00 PM">6:00 PM</option>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="numGuest" class="form-label small fw-semibold text-secondary">Number of Guests *</label>
                  <input type="number" name="numGuest" id="numGuest" min="1" max="13" class="form-control" placeholder="1 - 13" required>
                </div>
              </div>
            </div>

            <!-- Step 2 Bento Card: Available Tables -->
            <div class="bento-card p-4 p-md-4 mb-3">
              <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="bento-icon-box success" style="width:36px; height:36px; font-size:1.1rem;">
                    <i class="bi bi-2-circle-fill"></i>
                  </div>
                  <div>
                    <span class="section-kicker" style="color: #166534;">Step 2</span>
                    <h2 class="h6 fw-bold mb-0">Select Table & Seating</h2>
                  </div>
                </div>
                <button type="button" id="checkAvailabilityBtn" class="btn btn-outline-secondary btn-sm">
                  <i class="bi bi-arrow-clockwise"></i> Refresh Tables
                </button>
              </div>

              <input type="hidden" name="reserveFloor" id="reserveFloor" required>
              <input type="hidden" name="reserveTable" id="reserveTable" required>
              
              <div id="tableOptions" class="row g-2">
                <div class="col-12">
                  <div class="alert alert-light border mb-0 text-secondary small">
                    <i class="bi bi-info-circle me-1"></i> Enter date, time, and guest count to view available tables.
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 3 Bento Card: Guest Information -->
            <div class="bento-card p-4 p-md-4 mb-3">
              <div class="d-flex align-items-center gap-2 mb-3">
                <div class="bento-icon-box primary" style="width:36px; height:36px; font-size:1.1rem;">
                  <i class="bi bi-3-circle-fill"></i>
                </div>
                <div>
                  <span class="section-kicker" style="color: #1e40af;">Step 3</span>
                  <h2 class="h6 fw-bold mb-0">Guest Details</h2>
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-5">
                  <label for="firstName" class="form-label small fw-semibold text-secondary">First name *</label>
                  <input type="text" name="firstName" id="firstName" maxlength="100" class="form-control" placeholder="Given name" required>
                </div>
                <div class="col-md-5">
                  <label for="lastName" class="form-label small fw-semibold text-secondary">Last name *</label>
                  <input type="text" name="lastName" id="lastName" maxlength="100" class="form-control" placeholder="Family name" required>
                </div>
                <div class="col-md-2">
                  <label for="age" class="form-label small fw-semibold text-secondary">Age *</label>
                  <input type="number" name="age" id="age" min="18" max="80" class="form-control" placeholder="18-80" required>
                </div>
                <div class="col-md-6">
                  <label for="contactNum" class="form-label small fw-semibold text-secondary">Contact Number *</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light">+63</span>
                    <input type="text" name="contactNum" id="contactNum" pattern="\d{10}" minlength="10" maxlength="10" class="form-control" placeholder="9123456789" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="emailAdd" class="form-label small fw-semibold text-secondary">Email Address *</label>
                  <input type="email" name="emailAdd" id="emailAdd" maxlength="100" class="form-control" placeholder="name@example.com" required>
                </div>
                <div class="col-md-5">
                  <label for="occasion" class="form-label small fw-semibold text-secondary">Occasion</label>
                  <select name="occasion" id="occasion" class="form-select">
                    <option value="">None / Casual Dining</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Anniversary">Anniversary</option>
                    <option value="Business Meal">Business Meal</option>
                    <option value="Family Gathering">Family Gathering</option>
                  </select>
                </div>
                <div class="col-md-7">
                  <label for="specialRequest" class="form-label small fw-semibold text-secondary">Special Requests</label>
                  <input type="text" name="specialRequest" id="specialRequest" maxlength="1000" class="form-control" placeholder="Allergies, high chair, seating notes...">
                </div>
              </div>
            </div>

            <!-- Bento Card: Confirmation Action -->
            <div class="bento-card p-3 p-md-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
              <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" id="checkbox" required>
                <label class="form-check-label small" for="checkbox">
                  I accept the <a href="javascript:void(0)" class="text-decoration-underline text-primary" data-bs-target="#tc_modal" data-bs-toggle="modal">Terms and Conditions</a>
                </label>
              </div>
              <button type="submit" class="btn btn-accent px-4 py-2">
                <i class="bi bi-calendar-check me-1"></i> Confirm Reservation
              </button>
            </div>

          </form>
        </div>

        <!-- Bento Aside Column: Real-Time Booking Pass (4 cols) -->
        <div class="col-lg-4">
          <div class="bento-card p-4 position-sticky" style="top: 1.5rem;">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
              <span class="bento-tag">Live Summary</span>
              <span class="badge bg-light text-dark border">
                <i class="bi bi-shield-check text-success me-1"></i> BenHub
              </span>
            </div>

            <h3 class="h6 fw-bold mb-3">Booking Overview</h3>
            
            <div class="bg-light rounded-3 p-3 mb-3">
              <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="small text-secondary">Date:</span>
                <strong class="small text-dark" id="summaryDate">Not selected</strong>
              </div>
              <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="small text-secondary">Time Slot:</span>
                <strong class="small text-dark" id="summaryTime">Not selected</strong>
              </div>
              <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="small text-secondary">Guests:</span>
                <strong class="small text-dark" id="summaryGuests">Not selected</strong>
              </div>
              <div class="d-flex justify-content-between py-2">
                <span class="small text-secondary">Selected Table:</span>
                <strong class="small text-primary" id="summaryTable">Not selected</strong>
              </div>
            </div>

            <div class="small text-secondary mb-3">
              <i class="bi bi-qr-code text-warning me-1"></i> A digital booking pass with a scannable QR code will be generated immediately upon confirmation.
            </div>

            <div class="p-3 bg-white border rounded-3 text-center">
              <div class="small text-muted mb-1">Need help or private booking?</div>
              <a href="tel:<?= $phoneClean ?>" class="text-decoration-none fw-semibold small text-dark">
                <i class="bi bi-telephone text-primary me-1"></i> <?= $phoneNumber ?>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Reservation Confirmed & QR Code Modal -->
  <div class="modal fade" id="qrConfirmationModal" tabindex="-1" aria-labelledby="qrConfirmationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header bg-success text-white py-3">
          <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-3 me-2"></i>
            <div>
              <h5 class="modal-title fw-bold mb-0" id="qrConfirmationModalLabel">Reservation Confirmed!</h5>
              <div class="small opacity-75">Your table has been reserved</div>
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="mb-3">
            <span class="text-secondary small text-uppercase fw-bold">Confirmation Code</span>
            <div class="fs-3 fw-bold text-dark font-monospace" id="modalConfirmationCode">BH-XXXXXX</div>
          </div>

          <!-- QR Code Container -->
          <div class="d-flex flex-column align-items-center justify-content-center p-3 bg-light border rounded mb-3">
            <div id="reservationQRCode" class="bg-white p-2 border rounded shadow-sm"></div>
            <div class="small text-secondary mt-2">
              <i class="bi bi-camera"></i> Scan with phone to view reservation details
            </div>
          </div>

          <!-- Summary list -->
          <div class="text-start bg-light rounded p-3 mb-3 small">
            <div class="d-flex justify-content-between py-1 border-bottom">
              <span class="text-secondary">Guest:</span>
              <strong id="modalGuestName">-</strong>
            </div>
            <div class="d-flex justify-content-between py-1 border-bottom">
              <span class="text-secondary">Schedule:</span>
              <strong id="modalSchedule">-</strong>
            </div>
            <div class="d-flex justify-content-between py-1 border-bottom">
              <span class="text-secondary">Table & Floor:</span>
              <strong id="modalTable">-</strong>
            </div>
            <div class="d-flex justify-content-between py-1">
              <span class="text-secondary">Party Size:</span>
              <strong id="modalGuests">-</strong>
            </div>
          </div>

          <!-- Actions -->
          <div class="d-grid gap-2">
            <a id="modalViewPassBtn" href="#" target="_blank" class="btn btn-accent">
              <i class="bi bi-box-arrow-up-right me-1"></i> Open Digital Booking Pass
            </a>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  if(file_exists(__DIR__ . "/../../Terms/Views/tc_modal.php")) {
      include __DIR__ . "/../../Terms/Views/tc_modal.php";
  } else if (file_exists(__DIR__ . "/extras/tc_modal.php")) {
      include __DIR__ . "/extras/tc_modal.php";
  }
  include __DIR__ . "/extras/copyright.php";
  ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script src="/assets/js/qrcode.min.js"></script>
  <script>
    const reservationForm = document.getElementById('reservationForm');
    const tableOptions = document.getElementById('tableOptions');
    const feedback = document.getElementById('feedbackMessage');
    const reserveDate = document.getElementById('reserveDate');
    const reserveTime = document.getElementById('reserveTime');
    const numGuest = document.getElementById('numGuest');
    const reserveFloor = document.getElementById('reserveFloor');
    const reserveTable = document.getElementById('reserveTable');

    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    reserveDate.min = tomorrow.toISOString().split('T')[0];

    function updateSummary() {
      document.getElementById('summaryDate').textContent = reserveDate.value || 'Not selected';
      document.getElementById('summaryTime').textContent = reserveTime.value || 'Not selected';
      document.getElementById('summaryGuests').textContent = numGuest.value ? `${numGuest.value} Guest(s)` : 'Not selected';
      document.getElementById('summaryTable').textContent = reserveTable.value ? `${reserveTable.value} (${reserveFloor.value})` : 'Not selected';
    }

    let feedbackTimer = null;
    function showFeedback(type, message, durationMs = 6000) {
      if (feedbackTimer) {
        clearTimeout(feedbackTimer);
        feedbackTimer = null;
      }

      feedback.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show mb-4" role="alert">
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`;

      if (durationMs > 0) {
        feedbackTimer = setTimeout(() => {
          const alertEl = feedback.querySelector('.alert');
          if (alertEl) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
            bsAlert.close();
          }
        }, durationMs);
      }
    }

    function renderTables(tables) {
      reserveFloor.value = '';
      reserveTable.value = '';
      updateSummary();

      if (!tables.length) {
        tableOptions.innerHTML = '<div class="col-12"><div class="alert alert-warning mb-0">No matching tables are available for this slot. Try another time or guest count.</div></div>';
        return;
      }

      tableOptions.innerHTML = tables.map(table => `
        <div class="col-sm-6 col-md-4">
          <div class="table-option" tabindex="0" role="button" data-floor="${table.floor_name}" data-table="${table.table_name}">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <strong class="text-dark">${table.table_name}</strong>
              <span class="badge bg-light text-dark border">${table.capacity} guests</span>
            </div>
            <div class="small text-secondary">${table.floor_name} · ${table.area}</div>
          </div>
        </div>
      `).join('');
    }

    function checkAvailability() {
      if (!reserveDate.value || !reserveTime.value || !numGuest.value) {
        showFeedback('warning', 'Please select a date, time, and guest count first.');
        return;
      }

      tableOptions.innerHTML = '<div class="col-12"><div class="alert alert-light border mb-0"><span class="spinner-border spinner-border-sm me-2"></span>Checking available tables...</div></div>';

      const params = new URLSearchParams({
        date: reserveDate.value,
        time: reserveTime.value,
        guests: numGuest.value
      });

      fetch(`/api/reservations/availability?${params.toString()}`)
        .then(response => response.json().then(data => ({status: response.status, body: data})))
        .then(res => {
          if (res.status === 200 && res.body.status === 'success') {
            renderTables(res.body.data);
          } else {
            tableOptions.innerHTML = `<div class="col-12"><div class="alert alert-danger mb-0">${res.body.message || 'Error loading tables.'}</div></div>`;
          }
        })
        .catch(() => {
          tableOptions.innerHTML = '<div class="col-12"><div class="alert alert-danger mb-0">Could not load availability right now.</div></div>';
        });
    }

    document.getElementById('checkAvailabilityBtn').addEventListener('click', checkAvailability);
    [reserveDate, reserveTime, numGuest].forEach(input => {
      input.addEventListener('change', () => {
        updateSummary();
        if (reserveDate.value && reserveTime.value && numGuest.value) {
          checkAvailability();
        }
      });
      input.addEventListener('input', updateSummary);
    });

    tableOptions.addEventListener('click', function(e) {
      const option = e.target.closest('.table-option');
      if (!option) return;

      document.querySelectorAll('.table-option').forEach(item => item.classList.remove('active'));
      option.classList.add('active');
      reserveFloor.value = option.dataset.floor;
      reserveTable.value = option.dataset.table;
      updateSummary();
    });

    tableOptions.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        const option = e.target.closest('.table-option');
        if (option) {
          e.preventDefault();
          option.click();
        }
      }
    });

    reservationForm.addEventListener('submit', function(e) {
      e.preventDefault();

      if (!reserveFloor.value || !reserveTable.value) {
        showFeedback('warning', 'Please choose an available table before confirming.');
        return;
      }
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());
      data.contactNum = "+63" + data.contactNum;

      fetch('/api/reservations', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json().then(data => ({status: response.status, body: data})))
      .then(res => {
        if (res.status === 201) {
          const confCode = res.body.confirmationCode;
          const passUrl = `${window.location.origin}/reservation/view?code=${encodeURIComponent(confCode)}`;

          // Populate modal details
          document.getElementById('modalConfirmationCode').textContent = confCode;
          document.getElementById('modalGuestName').textContent = `${data.firstName} ${data.lastName}`;
          document.getElementById('modalSchedule').textContent = `${data.reserveDate} at ${data.reserveTime}`;
          document.getElementById('modalTable').textContent = `${data.reserveTable} (${data.reserveFloor})`;
          document.getElementById('modalGuests').textContent = `${data.numGuest} Guest${Number(data.numGuest) > 1 ? 's' : ''}`;
          document.getElementById('modalViewPassBtn').href = passUrl;

          // Generate QR code
          const qrContainer = document.getElementById('reservationQRCode');
          qrContainer.innerHTML = '';
          new QRCode(qrContainer, {
            text: passUrl,
            width: 160,
            height: 160,
            colorDark: "#0f172a",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
          });

          // Show QR modal
          const qrModal = new bootstrap.Modal(document.getElementById('qrConfirmationModal'));
          qrModal.show();

          // Set feedback alert with direct link to booking pass
          showFeedback('success', `
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
              <div>
                <strong>Reservation confirmed!</strong> Code: <strong>${confCode}</strong>
              </div>
              <div>
                <a href="${passUrl}" target="_blank" class="btn btn-sm btn-outline-success">
                  <i class="bi bi-qr-code"></i> View Booking Pass
                </a>
              </div>
            </div>
          `);

          this.reset();
          tableOptions.innerHTML = '<div class="col-12"><div class="alert alert-light border mb-0">Enter visit details to view available tables.</div></div>';
          reserveDate.min = tomorrow.toISOString().split('T')[0];
          updateSummary();
        } else {
          showFeedback('danger', `<strong>Sorry.</strong> ${res.body.message}`);
        }
      })
      .catch(() => {
        showFeedback('danger', 'An error occurred while submitting the reservation.');
      });
    });

    updateSummary();
  </script>
</body>
</html>
