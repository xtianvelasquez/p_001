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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <div class="container-fluid bg-light py-3 ps-4 mb-5 shadow-sm d-flex justify-content-between align-items-center">
    <h5 class="text-start m-0"><i class="bi bi-person-circle"></i>
      <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
    </h5>
    <button id="logoutBtn" class="btn btn-outline-danger btn-sm">Logout</button>
  </div>

  <main id="reservation_lists" class="bg-light py-5 my-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-md-10 px-5 px-md-0">
          <div id="feedbackMessage"></div>
          
          <div class="table-responsive-sm mt-4">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Floor</th>
                  <th>Table</th>
                  <th>Guest/s</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="reservationTableBody">
                <tr><td colspan="9" class="text-center">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php"; ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    // Fetch reservations
    function loadReservations() {
      fetch('/api/reservations')
        .then(response => response.json())
        .then(res => {
          const tbody = document.getElementById('reservationTableBody');
          tbody.innerHTML = '';
          if (res.status === 'success') {
            if (res.data.length === 0) {
              tbody.innerHTML = '<tr><td colspan="9" class="text-center">No reservations found.</td></tr>';
            } else {
              res.data.forEach(row => {
                tbody.innerHTML += `
                  <tr>
                    <td>${row.reservation_id}</td>
                    <td>${row.first_name} ${row.last_name}</td>
                    <td>${row.contact_num}<br>${row.email_add}</td>
                    <td>${row.reservation_date}</td>
                    <td>${row.reservation_time}</td>
                    <td>${row.reservation_floor}</td>
                    <td>${row.reservation_table}</td>
                    <td>${row.num_guest}</td>
                    <td>
                      <button class="btn btn-sm btn-danger" onclick="deleteReservation(${row.reservation_id})">Delete</button>
                    </td>
                  </tr>
                `;
              });
            }
          } else {
            tbody.innerHTML = `<tr><td colspan="9" class="text-danger text-center">Error: ${res.message}</td></tr>`;
          }
        });
    }

    // Delete reservation
    function deleteReservation(id) {
      if (confirm('Are you sure you want to delete this reservation?')) {
        fetch(`/api/reservations/${id}`, { method: 'DELETE' })
          .then(response => response.json())
          .then(res => {
            if (res.status === 'success') {
              loadReservations();
            } else {
              alert('Error deleting reservation: ' + res.message);
            }
          });
      }
    }

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function() {
      fetch('/api/auth/logout', { method: 'POST' })
        .then(() => {
          window.location.href = '/admin/login';
        });
    });

    // Initial load
    loadReservations();
  </script>
</body>
</html>
