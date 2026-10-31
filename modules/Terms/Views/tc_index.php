<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Terms and Conditions</title>
  <link rel="icon" type="image/png" href="/assets/images/benhub-icon.png">
  <link rel="shortcut icon" href="/assets/images/benhub-icon.png">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=2.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

  <?php
  include __DIR__ . "/../../Frontend/Views/extras/header.php";
  include __DIR__ . "/../../Frontend/Views/extras/nav_index.php";
  ?>

  <main id="terms_conditions" class="py-4 py-md-5">
    <div class="container-lg">
      
      <!-- Top Title Bento Banner -->
      <div class="bento-card bento-card-dark p-4 p-md-5 mb-4 position-relative">
        <span class="bento-tag mb-2">
          <i class="bi bi-shield-check"></i> Restaurant Policies & Privacy
        </span>
        <h1 class="h2 fw-bold text-white mb-2">Terms and Conditions</h1>
        <p class="text-light opacity-75 mb-0" style="max-width: 680px;">
          Please review our guest policies, reservation cancellation guidelines, and privacy protections before booking your appointment.
        </p>
      </div>

      <!-- Bento Layout: Sidebar Jump Links + Content Cards -->
      <div class="row g-3 g-lg-4">
        
        <!-- Sidebar Navigation (Col 4) -->
        <div class="col-lg-4">
          <div class="bento-card p-4 position-sticky" style="top: 1.5rem;">
            <span class="section-kicker">Quick Navigation</span>
            <h3 class="h6 fw-bold mt-1 mb-3">Policy Sections</h3>
            <div id="tc_titles" class="list-group list-group-flush small">
              <div class="text-muted py-2"><span class="spinner-border spinner-border-sm me-2"></span>Loading sections...</div>
            </div>

            <div class="pt-3 mt-3 border-top small text-secondary">
              <i class="bi bi-info-circle text-warning me-1"></i> For special inquiries or group bookings exceeding 12 guests, please contact restaurant management directly.
            </div>
          </div>
        </div>

        <!-- Main Content Stream (Col 8) -->
        <div class="col-lg-8" id="tc_descriptions">
          <div class="bento-card p-4 text-center text-muted">
            <span class="spinner-border spinner-border-sm me-2"></span>Loading terms and conditions...
          </div>
        </div>

      </div>

    </div>
  </main>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php" ?>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    function escapeHtml(value) {
      return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }[char]));
    }

    fetch('/api/terms')
      .then(response => response.json())
      .then(res => {
        if (res.status === 'success') {
          let titlesHtml = '';
          let descriptionsHtml = '';

          res.data.forEach(term => {
            const num = Number(term.tc_num);
            const title = escapeHtml(term.tc_title);
            const desc = escapeHtml(term.tc_description);

            titlesHtml += `
              <a href="#term_${num}" class="list-group-item list-group-item-action border-0 px-0 py-2 d-flex align-items-center text-secondary">
                <span class="badge bg-light text-dark border me-2">${num}</span>
                <span class="text-truncate">${title}</span>
              </a>`;

            descriptionsHtml += `
              <div class="bento-card p-4 mb-3" id="term_${num}">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1">Rule #${num}</span>
                  <h2 class="h5 fw-bold mb-0 text-dark">${title}</h2>
                </div>
                <p class="text-secondary mb-0 small" style="line-height: 1.6;">${desc}</p>
              </div>`;
          });

          document.getElementById('tc_titles').innerHTML = titlesHtml;
          document.getElementById('tc_descriptions').innerHTML = descriptionsHtml;
        } else {
          document.getElementById('tc_descriptions').innerHTML = '<div class="alert alert-danger">Could not load terms.</div>';
        }
      })
      .catch(() => {
        document.getElementById('tc_descriptions').innerHTML = '<div class="alert alert-danger">Network error loading terms.</div>';
      });
  </script>
</body>
</html>
