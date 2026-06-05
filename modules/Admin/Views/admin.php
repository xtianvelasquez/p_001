<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Admin</title>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <div class="admin-toolbar py-3">
    <div class="container-lg d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <p class="section-kicker mb-1">BenHub Admin</p>
        <h1 class="h4 fw-bold m-0"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
      </div>
      <button id="logoutBtn" class="btn btn-outline-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </div>
  </div>

  <main id="reservation_lists" class="py-5">
    <div class="container-lg">
      <div id="feedbackMessage"></div>

      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="stat-tile">
            <div class="text-secondary small">Total reservations</div>
            <div class="fs-3 fw-bold" id="statTotal">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-tile">
            <div class="text-secondary small">Today</div>
            <div class="fs-3 fw-bold" id="statToday">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-tile">
            <div class="text-secondary small">Upcoming guests</div>
            <div class="fs-3 fw-bold" id="statGuests">0</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-tile">
            <div class="text-secondary small">Active bookings</div>
            <div class="fs-3 fw-bold" id="statActive">0</div>
          </div>
        </div>
      </div>

      <div class="content-panel p-3 p-md-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
          <div>
            <p class="section-kicker mb-1">Reservations</p>
            <h2 class="h5 fw-bold mb-0">Manage bookings</h2>
          </div>
          <div class="row g-2 flex-grow-1 justify-content-lg-end">
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="search" id="searchInput" class="form-control" placeholder="Search name, code, contact">
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <input type="date" id="dateFilter" class="form-control">
            </div>
            <div class="col-sm-6 col-lg-3">
              <select id="statusFilter" class="form-select">
                <option value="">All statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="seated">Seated</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
                <option value="no_show">No-show</option>
              </select>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Code</th>
                <th>Guest</th>
                <th>Visit</th>
                <th>Table</th>
                <th>Notes</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="reservationTableBody">
              <tr><td colspan="7" class="text-center py-4">Loading...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php"; ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    let reservations = [];

    const tbody = document.getElementById('reservationTableBody');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const statusFilter = document.getElementById('statusFilter');
    const feedback = document.getElementById('feedbackMessage');
    const statusOptions = ['pending', 'confirmed', 'seated', 'completed', 'cancelled', 'no_show'];

    function escapeHtml(value) {
      return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }[char]));
    }

    function showFeedback(type, message) {
      feedback.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show mb-4">
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>`;
    }

    function normalizeStatus(status) {
      return status || 'confirmed';
    }

    function updateStats() {
      const today = new Date().toISOString().split('T')[0];
      const activeStatuses = ['pending', 'confirmed', 'seated'];
      const active = reservations.filter(row => activeStatuses.includes(normalizeStatus(row.status)));
      const upcomingGuests = active
        .filter(row => row.reservation_date >= today)
        .reduce((total, row) => total + Number(row.num_guest || 0), 0);

      document.getElementById('statTotal').textContent = reservations.length;
      document.getElementById('statToday').textContent = reservations.filter(row => row.reservation_date === today).length;
      document.getElementById('statGuests').textContent = upcomingGuests;
      document.getElementById('statActive').textContent = active.length;
    }

    function getFilteredReservations() {
      const query = searchInput.value.trim().toLowerCase();
      const selectedDate = dateFilter.value;
      const selectedStatus = statusFilter.value;

      return reservations.filter(row => {
        const status = normalizeStatus(row.status);
        const haystack = [
          row.confirmation_code,
          row.first_name,
          row.last_name,
          row.contact_num,
          row.email_add,
          row.reservation_table,
          row.reservation_floor
        ].join(' ').toLowerCase();

        return (!query || haystack.includes(query))
          && (!selectedDate || row.reservation_date === selectedDate)
          && (!selectedStatus || status === selectedStatus);
      });
    }

    function renderReservations() {
      const rows = getFilteredReservations();
      updateStats();

      if (rows.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No reservations found.</td></tr>';
        return;
      }

      tbody.innerHTML = rows.map(row => {
        const status = normalizeStatus(row.status);
        const statusClass = `status-${status}`;
        const options = statusOptions.map(option => `<option value="${option}" ${option === status ? 'selected' : ''}>${option.replace('_', ' ')}</option>`).join('');
        const notes = [row.occasion, row.special_request].filter(Boolean).map(escapeHtml).join('<br>');

        return `
          <tr>
            <td>
              <strong>${escapeHtml(row.confirmation_code || `#${row.reservation_id}`)}</strong>
              <div class="small text-secondary">ID ${escapeHtml(row.reservation_id)}</div>
            </td>
            <td>
              <strong>${escapeHtml(row.first_name)} ${escapeHtml(row.last_name)}</strong>
              <div class="small text-secondary">${escapeHtml(row.contact_num)}</div>
              <div class="small text-secondary">${escapeHtml(row.email_add)}</div>
            </td>
            <td>
              <strong>${escapeHtml(row.reservation_date)}</strong>
              <div class="small text-secondary">${escapeHtml(row.reservation_time)} · ${escapeHtml(row.num_guest)} guests</div>
            </td>
            <td>${escapeHtml(row.reservation_table)}<div class="small text-secondary">${escapeHtml(row.reservation_floor)}</div></td>
            <td>${notes || '<span class="text-secondary">None</span>'}</td>
            <td>
              <span class="status-pill ${statusClass} d-inline-block mb-2">${status.replace('_', ' ')}</span>
              <select class="form-select form-select-sm status-select" data-id="${row.reservation_id}">
                ${options}
              </select>
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.reservation_id}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `;
      }).join('');
    }

    function loadReservations() {
      fetch('/api/reservations')
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            reservations = res.data;
            renderReservations();
          } else {
            tbody.innerHTML = `<tr><td colspan="7" class="text-danger text-center py-4">Error: ${escapeHtml(res.message)}</td></tr>`;
          }
        })
        .catch(() => {
          tbody.innerHTML = '<tr><td colspan="7" class="text-danger text-center py-4">Could not load reservations.</td></tr>';
        });
    }

    function updateReservationStatus(id, status) {
      fetch(`/api/reservations/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status })
      })
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            showFeedback('success', 'Reservation status updated.');
            loadReservations();
          } else {
            showFeedback('danger', res.message);
          }
        })
        .catch(() => showFeedback('danger', 'Could not update reservation status.'));
    }

    function deleteReservation(id) {
      if (!confirm('Delete this reservation permanently?')) {
        return;
      }

      fetch(`/api/reservations/${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            showFeedback('success', 'Reservation deleted.');
            loadReservations();
          } else {
            showFeedback('danger', 'Error deleting reservation: ' + res.message);
          }
        })
        .catch(() => showFeedback('danger', 'Could not delete reservation.'));
    }

    tbody.addEventListener('change', event => {
      if (event.target.classList.contains('status-select')) {
        updateReservationStatus(event.target.dataset.id, event.target.value);
      }
    });

    tbody.addEventListener('click', event => {
      const deleteButton = event.target.closest('.delete-btn');
      if (deleteButton) {
        deleteReservation(deleteButton.dataset.id);
      }
    });

    [searchInput, dateFilter, statusFilter].forEach(input => {
      input.addEventListener('input', renderReservations);
      input.addEventListener('change', renderReservations);
    });

    document.getElementById('logoutBtn').addEventListener('click', function() {
      fetch('/api/auth/logout', { method: 'POST' })
        .then(() => {
          window.location.href = '/admin/login';
        });
    });

    loadReservations();
  </script>
</body>
</html>
