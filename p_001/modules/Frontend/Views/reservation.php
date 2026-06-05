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

  <?php
  if(file_exists(__DIR__ . "/../../Terms/Views/tc_modal.php")) {
      include __DIR__ . "/../../Terms/Views/tc_modal.php";
  } else if (file_exists(__DIR__ . "/extras/tc_modal.php")) {
      include __DIR__ . "/extras/tc_modal.php";
  }
  include __DIR__ . "/extras/copyright.php";
  ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
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
          showFeedback('success', `<strong>Reservation confirmed.</strong> Your confirmation code is <strong>${res.body.confirmationCode}</strong>.`);
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
