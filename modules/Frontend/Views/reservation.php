<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Reservation</title>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <?php
  include __DIR__ . "/extras/header.php";
  include __DIR__ . "/extras/nav_index.php";
  ?>

  <main id="reservation" class="py-5">
    <div class="container-lg">
      <div class="row justify-content-center mb-4">
        <div class="col-lg-9 text-center">
          <p class="section-kicker mb-2">Reservations</p>
          <h1 class="display-6 fw-bold mb-3">Book a table with confidence</h1>
          <p class="lead text-secondary mb-0">Choose your visit details, pick an available table, and receive a confirmation code instantly.</p>
        </div>
      </div>

      <div class="row justify-content-center g-4">
        <div class="col-lg-8">
          <div class="content-panel p-4 p-md-5">
            <div id="feedbackMessage"></div>

            <form id="reservationForm" autocomplete="off">
              <div class="mb-4">
                <p class="section-kicker mb-2">Step 1</p>
                <h2 class="h5 fw-bold mb-3">Visit details</h2>
                <div class="row g-3">
                  <div class="col-md-4">
                    <label for="reserveDate" class="form-label">Date</label>
                    <input type="date" name="reserveDate" id="reserveDate" class="form-control" required>
                  </div>
                  <div class="col-md-4">
                    <label for="reserveTime" class="form-label">Time</label>
                    <select name="reserveTime" id="reserveTime" class="form-select" required>
                      <option value="10:00 AM">10:00 AM</option>
                      <option value="10:30 AM">10:30 AM</option>
                      <option value="11:00 AM">11:00 AM</option>
                      <option value="11:30 AM">11:30 AM</option>
                      <option value="12:00 PM">12:00 NN</option>
                      <option value="12:30 PM">12:30 PM</option>
                      <option value="1:00 PM">1:00 PM</option>
                      <option value="1:30 PM">1:30 PM</option>
                      <option value="2:00 PM">2:00 PM</option>
                      <option value="2:30 PM">2:30 PM</option>
                      <option value="3:00 PM">3:00 PM</option>
                      <option value="3:30 PM">3:30 PM</option>
                      <option value="4:00 PM">4:00 PM</option>
                      <option value="4:30 PM">4:30 PM</option>
                      <option value="5:00 PM">5:00 PM</option>
                      <option value="5:30 PM">5:30 PM</option>
                      <option value="6:00 PM">6:00 PM</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="numGuest" class="form-label">Guests</label>
                    <input type="number" name="numGuest" id="numGuest" min="1" max="13" class="form-control" required>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">
                  <div>
                    <p class="section-kicker mb-2">Step 2</p>
                    <h2 class="h5 fw-bold mb-0">Available tables</h2>
                  </div>
                  <button type="button" id="checkAvailabilityBtn" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Check availability
                  </button>
                </div>
                <input type="hidden" name="reserveFloor" id="reserveFloor" required>
                <input type="hidden" name="reserveTable" id="reserveTable" required>
                <div id="tableOptions" class="row g-3">
                  <div class="col-12">
                    <div class="alert alert-light border mb-0">Enter visit details to view available tables.</div>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <p class="section-kicker mb-2">Step 3</p>
                <h2 class="h5 fw-bold mb-3">Guest information</h2>
                <div class="row g-3">
                  <div class="col-md-5">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" name="firstName" id="firstName" maxlength="100" class="form-control" required>
                  </div>
                  <div class="col-md-5">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" name="lastName" id="lastName" maxlength="100" class="form-control" required>
                  </div>
                  <div class="col-md-2">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" id="age" min="18" max="80" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="contactNum" class="form-label">Contact number</label>
                    <div class="input-group">
                      <span class="input-group-text">+63</span>
                      <input type="text" name="contactNum" id="contactNum" pattern="\d{10}" minlength="10" maxlength="10" class="form-control" placeholder="9123456789" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="emailAdd" class="form-label">Email address</label>
                    <input type="email" name="emailAdd" id="emailAdd" maxlength="100" class="form-control" placeholder="info@example.com" required>
                  </div>
                  <div class="col-md-5">
                    <label for="occasion" class="form-label">Occasion</label>
                    <select name="occasion" id="occasion" class="form-select">
                      <option value="">None</option>
                      <option value="Birthday">Birthday</option>
                      <option value="Anniversary">Anniversary</option>
                      <option value="Business Meal">Business Meal</option>
                      <option value="Family Gathering">Family Gathering</option>
                    </select>
                  </div>
                  <div class="col-md-7">
                    <label for="specialRequest" class="form-label">Special request</label>
                    <input type="text" name="specialRequest" id="specialRequest" maxlength="1000" class="form-control" placeholder="Allergies, seating preference, accessibility needs">
                  </div>
                </div>
              </div>

              <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                  <input type="checkbox" id="checkbox" required>
                  <label for="checkbox">I accept the <span class="text-primary" role="button" data-bs-target="#tc_modal" data-bs-toggle="modal">terms and conditions</span>.</label>
                </div>
                <button type="submit" class="btn btn-accent py-2 px-4">
                  <i class="bi bi-calendar-check"></i> Confirm reservation
                </button>
              </div>
            </form>
          </div>
        </div>

        <aside class="col-lg-4">
          <div class="content-panel p-4 position-sticky" style="top: 1rem;">
            <p class="section-kicker mb-2">Summary</p>
            <h2 class="h5 fw-bold mb-3">Your booking</h2>
            <dl class="row mb-0">
              <dt class="col-5 text-secondary fw-normal">Date</dt>
              <dd class="col-7" id="summaryDate">Not selected</dd>
              <dt class="col-5 text-secondary fw-normal">Time</dt>
              <dd class="col-7" id="summaryTime">Not selected</dd>
              <dt class="col-5 text-secondary fw-normal">Guests</dt>
              <dd class="col-7" id="summaryGuests">Not selected</dd>
              <dt class="col-5 text-secondary fw-normal">Table</dt>
              <dd class="col-7" id="summaryTable">Not selected</dd>
            </dl>
          </div>
        </aside>
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
      document.getElementById('summaryGuests').textContent = numGuest.value || 'Not selected';
      document.getElementById('summaryTable').textContent = reserveTable.value ? `${reserveTable.value}, ${reserveFloor.value}` : 'Not selected';
    }

    function showFeedback(type, message) {
      feedback.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show mb-4">
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>`;
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
        <div class="col-md-6">
          <div class="table-option" tabindex="0" role="button" data-floor="${table.floor_name}" data-table="${table.table_name}">
            <div class="d-flex justify-content-between gap-3">
              <strong>${table.table_name}</strong>
              <span class="text-secondary">${table.capacity} seats</span>
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

      tableOptions.innerHTML = '<div class="col-12"><div class="alert alert-light border mb-0">Checking available tables...</div></div>';

      const params = new URLSearchParams({
        date: reserveDate.value,
        time: reserveTime.value,
        guests: numGuest.value
      });

      fetch(`/api/reservations/availability?${params.toString()}`)
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            renderTables(res.data);
          } else {
            tableOptions.innerHTML = `<div class="col-12"><div class="alert alert-danger mb-0">${res.message}</div></div>`;
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
    });

    tableOptions.addEventListener('click', event => {
      const option = event.target.closest('.table-option');
      if (!option) return;
      document.querySelectorAll('.table-option').forEach(item => item.classList.remove('active'));
      option.classList.add('active');
      reserveFloor.value = option.dataset.floor;
      reserveTable.value = option.dataset.table;
      updateSummary();
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
