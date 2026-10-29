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
  <div class="admin-toolbar py-2 py-md-3">
    <div class="container-lg d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <p class="section-kicker mb-0" style="font-size: 0.75rem;">BenHub Admin</p>
        <h1 class="h5 fw-bold m-0"><i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
      </div>

      <!-- Navigation Tabs inside header before logout button -->
      <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 gap-md-3">
        <ul class="nav nav-pills gap-1" id="adminTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-3 py-2 fw-semibold" id="reservations-tab" data-bs-toggle="tab" data-bs-target="#reservationsPane" type="button" role="tab" aria-controls="reservationsPane" aria-selected="true">
              <i class="bi bi-calendar2-check me-1"></i> Reservations
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="seatings-tab" data-bs-toggle="tab" data-bs-target="#seatingsPane" type="button" role="tab" aria-controls="seatingsPane" aria-selected="false">
              <i class="bi bi-grid-3x3-gap-fill me-1"></i> Seating Management
            </button>
          </li>
        </ul>

        <button id="logoutBtn" class="btn btn-outline-danger btn-sm px-3 py-2">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </div>
    </div>
  </div>

  <main id="admin_main" class="py-5">
    <div class="container-lg">
      <div id="feedbackMessage"></div>

      <div class="tab-content" id="adminTabsContent">
        <!-- ==================== TAB 1: RESERVATIONS ==================== -->
        <div class="tab-pane fade show active" id="reservationsPane" role="tabpanel" aria-labelledby="reservations-tab">
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
                  <tr><td colspan="7" class="text-center py-4">Loading reservations...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ==================== TAB 2: SEATING MANAGEMENT ==================== -->
        <div class="tab-pane fade" id="seatingsPane" role="tabpanel" aria-labelledby="seatings-tab">
          <!-- Seating Stat Tiles -->
          <div class="row g-3 mb-4">
            <div class="col-md-3">
              <div class="stat-tile">
                <div class="text-secondary small">Total tables</div>
                <div class="fs-3 fw-bold" id="statTablesTotal">0</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-tile">
                <div class="text-secondary small">Active tables</div>
                <div class="fs-3 fw-bold text-success" id="statTablesActive">0</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-tile">
                <div class="text-secondary small">Total guest capacity</div>
                <div class="fs-3 fw-bold" id="statTotalCapacity">0</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-tile">
                <div class="text-secondary small">Floors / Levels</div>
                <div class="fs-3 fw-bold" id="statFloorsCount">0</div>
              </div>
            </div>
          </div>

          <!-- Seating Content Panel -->
          <div class="content-panel p-3 p-md-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
              <div>
                <p class="section-kicker mb-1">Floor Plan & Capacity</p>
                <h2 class="h5 fw-bold mb-0">Restaurant Tables & Seating</h2>
                <div class="small text-secondary">Update tables, floors, and capacities to adjust live customer booking availability.</div>
              </div>
              <div>
                <button type="button" class="btn btn-accent btn-sm px-3 py-2" id="openAddTableBtn">
                  <i class="bi bi-plus-circle me-1"></i> Add Table
                </button>
              </div>
            </div>

            <!-- Filters -->
            <div class="row g-2 mb-4">
              <div class="col-md-5">
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input type="search" id="seatingSearchInput" class="form-control" placeholder="Search table name, floor, area...">
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <select id="seatingFloorFilter" class="form-select">
                  <option value="">All Floors</option>
                </select>
              </div>
              <div class="col-sm-6 col-md-3">
                <select id="seatingStatusFilter" class="form-select">
                  <option value="">All Statuses</option>
                  <option value="active">Active Only</option>
                  <option value="inactive">Inactive Only</option>
                </select>
              </div>
            </div>

            <!-- Seating Tables List -->
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th>Table Name</th>
                    <th>Floor</th>
                    <th>Capacity</th>
                    <th>Area / Section</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>
                <tbody id="seatingTableBody">
                  <tr><td colspan="7" class="text-center py-4">Loading seatings...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Reservation Delete Confirmation Modal -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="deleteConfirmModalLabel">Confirm Reservation Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-1">Are you sure you want to delete this reservation permanently?</p>
          <div id="deleteModalTargetDetails" class="small text-secondary"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add / Edit Table Modal -->
  <div class="modal fade" id="tableFormModal" tabindex="-1" aria-labelledby="tableFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="tableForm">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="tableFormModalLabel">Add New Table</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editTableId" value="">
            
            <div class="mb-3">
              <label for="tableNameInput" class="form-label small fw-semibold">Table Name *</label>
              <input type="text" class="form-control" id="tableNameInput" placeholder="e.g. Table 11, VIP Booth" required maxlength="50">
            </div>

            <div class="row g-2 mb-3">
              <div class="col-md-7">
                <label for="tableFloorSelect" class="form-label small fw-semibold">Floor / Level *</label>
                <select class="form-select" id="tableFloorSelect" required>
                  <!-- Populated dynamically -->
                </select>
              </div>
              <div class="col-md-5">
                <label for="tableCapacityInput" class="form-label small fw-semibold">Guest Capacity *</label>
                <input type="number" class="form-control" id="tableCapacityInput" min="1" max="50" placeholder="e.g. 4" required>
              </div>
            </div>

            <div class="mb-3" id="customFloorGroup" style="display: none;">
              <label for="customFloorInput" class="form-label small fw-semibold">New Floor Name</label>
              <input type="text" class="form-control" id="customFloorInput" placeholder="e.g. Rooftop Terrace" maxlength="50">
            </div>

            <div class="mb-3">
              <label for="tableAreaInput" class="form-label small fw-semibold">Area / Section</label>
              <input type="text" class="form-control" id="tableAreaInput" placeholder="e.g. Main Dining, Window, Patio, Private Room" maxlength="100">
            </div>

            <div class="mb-3">
              <label for="tableDescInput" class="form-label small fw-semibold">Description / Notes</label>
              <textarea class="form-control" id="tableDescInput" rows="2" placeholder="Optional notes for host or seating preference" maxlength="255"></textarea>
            </div>

            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" id="tableActiveSwitch" checked>
              <label class="form-check-label small fw-semibold" for="tableActiveSwitch">Active for reservations</label>
              <div class="form-text small">Inactive tables are temporarily hidden from the customer reservation form.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-accent" id="saveTableBtn">Save Table</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Table Modal -->
  <div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="deleteTableModalLabel">Delete Table</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-1">Are you sure you want to delete this table permanently?</p>
          <div id="deleteTableTargetDetails" class="p-2 bg-light rounded mt-2 small"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteTableBtn">Delete Table</button>
        </div>
      </div>
    </div>
  </div>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php"; ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    // ==========================================
    // SHARED UTILITIES
    // ==========================================
    function escapeHtml(value) {
      return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }[char]));
    }

    const feedback = document.getElementById('feedbackMessage');
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
      window.scrollTo({ top: 0, behavior: 'smooth' });

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

    // ==========================================
    // RESERVATIONS TAB LOGIC
    // ==========================================
    let reservations = [];
    const tbody = document.getElementById('reservationTableBody');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const statusFilter = document.getElementById('statusFilter');
    const statusOptions = ['pending', 'confirmed', 'seated', 'completed', 'cancelled', 'no_show'];

    function normalizeStatus(status) {
      return status || 'confirmed';
    }

    function calculateMetrics() {
      const today = new Date().toISOString().split('T')[0];
      const activeStatuses = ['pending', 'confirmed', 'seated'];

      document.getElementById('statTotal').textContent = reservations.length;
      document.getElementById('statToday').textContent = reservations.filter(r => r.reservation_date === today).length;
      document.getElementById('statGuests').textContent = reservations
        .filter(r => activeStatuses.includes(normalizeStatus(r.status)))
        .reduce((sum, r) => sum + Number(r.num_guest || 0), 0);
      document.getElementById('statActive').textContent = reservations
        .filter(r => activeStatuses.includes(normalizeStatus(r.status))).length;
    }

    function renderReservations() {
      const term = searchInput.value.trim().toLowerCase();
      const date = dateFilter.value;
      const status = statusFilter.value;

      const rows = reservations.filter(row => {
        const matchesTerm = !term || [
          row.first_name,
          row.last_name,
          row.confirmation_code,
          row.contact_num,
          row.email_add,
          row.reservation_table,
          row.reservation_floor
        ].some(field => String(field || '').toLowerCase().includes(term));

        const matchesDate = !date || row.reservation_date === date;
        const matchesStatus = !status || normalizeStatus(row.status) === status;

        return matchesTerm && matchesDate && matchesStatus;
      });

      if (rows.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-secondary">No reservations found.</td></tr>';
        return;
      }

      tbody.innerHTML = rows.map(row => {
        const currentStatus = normalizeStatus(row.status);
        const statusClass = `status-${currentStatus}`;
        const options = statusOptions.map(option => `<option value="${option}" ${option === currentStatus ? 'selected' : ''}>${option.replace('_', ' ')}</option>`).join('');
        const notes = [row.occasion, row.special_request].filter(Boolean).map(escapeHtml).join('<br>');

        return `
          <tr>
            <td>
              <strong>${escapeHtml(row.confirmation_code || `#${row.reservation_id}`)}</strong>
              <div class="small text-secondary">ID #${escapeHtml(row.reservation_id)}</div>
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
            <td>${notes || '<span class="text-secondary small">None</span>'}</td>
            <td>
              <span class="status-pill ${statusClass} d-inline-block mb-2">${currentStatus.replace('_', ' ')}</span>
              <select class="form-select form-select-sm status-select" data-id="${row.reservation_id}">
                ${options}
              </select>
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.reservation_id}" title="Delete reservation">
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
            calculateMetrics();
            renderReservations();
          } else {
            tbody.innerHTML = `<tr><td colspan="7" class="text-danger text-center py-4">Error: ${escapeHtml(res.message)}</td></tr>`;
          }
        })
        .catch(() => {
          tbody.innerHTML = '<tr><td colspan="7" class="text-danger text-center py-4">Could not load reservations.</td></tr>';
        });
    }

    function updateReservationStatus(id, newStatus) {
      fetch(`/api/reservations/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus })
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

    const deleteModalEl = document.getElementById('deleteConfirmModal');
    const deleteModal = new bootstrap.Modal(deleteModalEl);
    let reservationIdToDelete = null;

    function openDeleteModal(id) {
      reservationIdToDelete = id;
      const resObj = reservations.find(r => String(r.reservation_id) === String(id));
      const detailsEl = document.getElementById('deleteModalTargetDetails');
      if (resObj) {
        const code = resObj.confirmation_code || `#${resObj.reservation_id}`;
        const guest = `${resObj.first_name || ''} ${resObj.last_name || ''}`.trim();
        detailsEl.innerHTML = `Reservation: <strong>${escapeHtml(code)}</strong> (${escapeHtml(guest)})`;
      } else {
        detailsEl.textContent = '';
      }
      deleteModal.show();
    }

    function executeDeleteReservation() {
      if (!reservationIdToDelete) return;

      const id = reservationIdToDelete;
      deleteModal.hide();

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
        .catch(() => showFeedback('danger', 'Could not delete reservation.'))
        .finally(() => {
          reservationIdToDelete = null;
        });
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', executeDeleteReservation);

    tbody.addEventListener('change', event => {
      if (event.target.classList.contains('status-select')) {
        updateReservationStatus(event.target.dataset.id, event.target.value);
      }
    });

    tbody.addEventListener('click', event => {
      const deleteButton = event.target.closest('.delete-btn');
      if (deleteButton) {
        openDeleteModal(deleteButton.dataset.id);
      }
    });

    [searchInput, dateFilter, statusFilter].forEach(input => {
      input.addEventListener('input', renderReservations);
      input.addEventListener('change', renderReservations);
    });

    // ==========================================
    // SEATING MANAGEMENT TAB LOGIC
    // ==========================================
    let seatingTables = [];
    let seatingFloors = [];

    const seatingTbody = document.getElementById('seatingTableBody');
    const seatingSearchInput = document.getElementById('seatingSearchInput');
    const seatingFloorFilter = document.getElementById('seatingFloorFilter');
    const seatingStatusFilter = document.getElementById('seatingStatusFilter');

    const tableModalEl = document.getElementById('tableFormModal');
    const tableModal = new bootstrap.Modal(tableModalEl);
    const tableForm = document.getElementById('tableForm');

    const deleteTableModalEl = document.getElementById('deleteTableModal');
    const deleteTableModal = new bootstrap.Modal(deleteTableModalEl);
    let tableIdToDelete = null;

    function calculateSeatingMetrics() {
      const total = seatingTables.length;
      const active = seatingTables.filter(t => t.is_active).length;
      const totalCapacity = seatingTables.filter(t => t.is_active).reduce((sum, t) => sum + Number(t.capacity || 0), 0);
      const uniqueFloors = new Set(seatingTables.map(t => t.floor_name)).size;

      document.getElementById('statTablesTotal').textContent = total;
      document.getElementById('statTablesActive').textContent = active;
      document.getElementById('statTotalCapacity').textContent = totalCapacity;
      document.getElementById('statFloorsCount').textContent = Math.max(uniqueFloors, seatingFloors.length);
    }

    function populateFloorDropdowns() {
      const currentSelected = seatingFloorFilter.value;
      const floorNames = Array.from(new Set([
        ...seatingFloors.map(f => f.floor_name),
        ...seatingTables.map(t => t.floor_name)
      ])).sort();

      // Filter select
      seatingFloorFilter.innerHTML = '<option value="">All Floors</option>' + 
        floorNames.map(f => `<option value="${escapeHtml(f)}" ${f === currentSelected ? 'selected' : ''}>${escapeHtml(f)}</option>`).join('');

      // Form select
      const tableFloorSelect = document.getElementById('tableFloorSelect');
      tableFloorSelect.innerHTML = floorNames.map(f => `<option value="${escapeHtml(f)}">${escapeHtml(f)}</option>`).join('') +
        '<option value="__NEW__">+ Add Custom Floor...</option>';
    }

    document.getElementById('tableFloorSelect').addEventListener('change', function() {
      const customGroup = document.getElementById('customFloorGroup');
      const customInput = document.getElementById('customFloorInput');
      if (this.value === '__NEW__') {
        customGroup.style.display = 'block';
        customInput.required = true;
        customInput.focus();
      } else {
        customGroup.style.display = 'none';
        customInput.required = false;
      }
    });

    function renderSeatings() {
      const term = seatingSearchInput.value.trim().toLowerCase();
      const floor = seatingFloorFilter.value;
      const status = seatingStatusFilter.value;

      const rows = seatingTables.filter(t => {
        const matchesTerm = !term || [
          t.table_name,
          t.floor_name,
          t.area,
          t.description
        ].some(val => String(val || '').toLowerCase().includes(term));

        const matchesFloor = !floor || t.floor_name === floor;
        const matchesStatus = !status || (status === 'active' ? t.is_active : !t.is_active);

        return matchesTerm && matchesFloor && matchesStatus;
      });

      if (rows.length === 0) {
        seatingTbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-secondary">No tables match your criteria.</td></tr>';
        return;
      }

      seatingTbody.innerHTML = rows.map(t => {
        const isActive = Boolean(t.is_active);
        const statusBadge = isActive 
          ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>'
          : '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-dash-circle me-1"></i>Inactive</span>';

        return `
          <tr>
            <td>
              <strong class="text-dark">${escapeHtml(t.table_name)}</strong>
              <div class="small text-secondary">ID #${escapeHtml(t.table_id)}</div>
            </td>
            <td>
              <span class="badge bg-light text-dark border">${escapeHtml(t.floor_name)}</span>
            </td>
            <td>
              <span class="fw-semibold">${escapeHtml(t.capacity)}</span> <span class="small text-secondary">guests</span>
            </td>
            <td>
              <span class="text-secondary">${escapeHtml(t.area || 'Main Dining')}</span>
            </td>
            <td>
              <span class="small text-secondary">${escapeHtml(t.description || '—')}</span>
            </td>
            <td>
              <div class="d-flex align-items-center gap-2">
                ${statusBadge}
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 toggle-table-btn" data-id="${t.table_id}" title="Toggle active status">
                  <i class="bi bi-arrow-repeat"></i>
                </button>
              </div>
            </td>
            <td class="text-end">
              <button type="button" class="btn btn-sm btn-outline-primary edit-table-btn me-1" data-id="${t.table_id}" title="Edit table">
                <i class="bi bi-pencil"></i>
              </button>
              <button type="button" class="btn btn-sm btn-outline-danger delete-table-btn" data-id="${t.table_id}" title="Delete table">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `;
      }).join('');
    }

    function loadSeatings() {
      fetch('/api/seatings')
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            seatingTables = res.data.tables;
            seatingFloors = res.data.floors;
            calculateSeatingMetrics();
            populateFloorDropdowns();
            renderSeatings();
          } else {
            seatingTbody.innerHTML = `<tr><td colspan="7" class="text-danger text-center py-4">Error: ${escapeHtml(res.message)}</td></tr>`;
          }
        })
        .catch(() => {
          seatingTbody.innerHTML = '<tr><td colspan="7" class="text-danger text-center py-4">Could not load seating tables.</td></tr>';
        });
    }

    // Seating Filters Event Listeners
    [seatingSearchInput, seatingFloorFilter, seatingStatusFilter].forEach(el => {
      el.addEventListener('input', renderSeatings);
      el.addEventListener('change', renderSeatings);
    });

    // Open Add Table Modal
    document.getElementById('openAddTableBtn').addEventListener('click', function() {
      document.getElementById('tableFormModalLabel').textContent = 'Add New Table';
      document.getElementById('editTableId').value = '';
      tableForm.reset();
      document.getElementById('tableActiveSwitch').checked = true;
      document.getElementById('customFloorGroup').style.display = 'none';
      tableModal.show();
    });

    // Add / Edit Table Form Submit
    tableForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const editId = document.getElementById('editTableId').value;
      const floorSelect = document.getElementById('tableFloorSelect');
      let floorName = floorSelect.value;
      if (floorName === '__NEW__') {
        floorName = document.getElementById('customFloorInput').value.trim();
      }

      const payload = {
        table_name: document.getElementById('tableNameInput').value.trim(),
        floor_name: floorName,
        capacity: Number(document.getElementById('tableCapacityInput').value),
        area: document.getElementById('tableAreaInput').value.trim(),
        description: document.getElementById('tableDescInput').value.trim(),
        is_active: document.getElementById('tableActiveSwitch').checked
      };

      const url = editId ? `/api/seatings/${editId}` : '/api/seatings';
      const method = editId ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      })
      .then(response => response.json())
      .then(res => {
        if (res.status === 'success') {
          tableModal.hide();
          showFeedback('success', res.message);
          loadSeatings();
        } else {
          alert('Error: ' + res.message);
        }
      })
      .catch(() => alert('Could not save table. Please try again.'));
    });

    // Seating Table Actions Click
    seatingTbody.addEventListener('click', function(e) {
      // Toggle Status
      const toggleBtn = e.target.closest('.toggle-table-btn');
      if (toggleBtn) {
        const id = toggleBtn.dataset.id;
        fetch(`/api/seatings/${id}/toggle`, { method: 'PATCH' })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              showFeedback('success', res.message);
              loadSeatings();
            } else {
              showFeedback('danger', res.message);
            }
          })
          .catch(() => showFeedback('danger', 'Could not toggle table status.'));
        return;
      }

      // Edit Table
      const editBtn = e.target.closest('.edit-table-btn');
      if (editBtn) {
        const id = editBtn.dataset.id;
        const table = seatingTables.find(t => String(t.table_id) === String(id));
        if (table) {
          document.getElementById('tableFormModalLabel').textContent = `Edit Table: ${table.table_name}`;
          document.getElementById('editTableId').value = table.table_id;
          document.getElementById('tableNameInput').value = table.table_name;
          document.getElementById('tableCapacityInput').value = table.capacity;
          document.getElementById('tableAreaInput').value = table.area || '';
          document.getElementById('tableDescInput').value = table.description || '';
          document.getElementById('tableActiveSwitch').checked = Boolean(table.is_active);

          const floorSelect = document.getElementById('tableFloorSelect');
          floorSelect.value = table.floor_name;
          document.getElementById('customFloorGroup').style.display = 'none';

          tableModal.show();
        }
        return;
      }

      // Delete Table
      const deleteBtn = e.target.closest('.delete-table-btn');
      if (deleteBtn) {
        const id = deleteBtn.dataset.id;
        const table = seatingTables.find(t => String(t.table_id) === String(id));
        if (table) {
          tableIdToDelete = id;
          document.getElementById('deleteTableTargetDetails').innerHTML = `
            <strong>${escapeHtml(table.table_name)}</strong> on <strong>${escapeHtml(table.floor_name)}</strong> 
            (${escapeHtml(table.capacity)} guests, ${escapeHtml(table.area || 'Main Dining')})
          `;
          deleteTableModal.show();
        }
      }
    });

    // Confirm Delete Table
    document.getElementById('confirmDeleteTableBtn').addEventListener('click', function() {
      if (!tableIdToDelete) return;

      const id = tableIdToDelete;
      deleteTableModal.hide();

      fetch(`/api/seatings/${id}`, { method: 'DELETE' })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            showFeedback('success', res.message);
            loadSeatings();
          } else {
            showFeedback('danger', res.message);
          }
        })
        .catch(() => showFeedback('danger', 'Could not delete table.'))
        .finally(() => {
          tableIdToDelete = null;
        });
    });

    // Tab change triggers seating load if empty
    document.getElementById('seatings-tab').addEventListener('shown.bs.tab', function() {
      if (seatingTables.length === 0) {
        loadSeatings();
      }
    });

    // ==========================================
    // LOGOUT
    // ==========================================
    document.getElementById('logoutBtn').addEventListener('click', function() {
      fetch('/api/auth/logout', { method: 'POST' })
        .then(() => {
          window.location.href = '/admin/login';
        });
    });

    // Initial load
    loadReservations();
    loadSeatings();
  </script>
</body>
</html>
