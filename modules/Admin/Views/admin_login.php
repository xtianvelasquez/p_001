<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Administration</title>
  <link rel="icon" type="image/png" href="/assets/images/benhub-icon.png">
  <link rel="shortcut icon" href="/assets/images/benhub-icon.png">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="/assets/css/app.css?v=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    html, body {
      height: 100%;
    }
    .login-split-img {
      object-fit: cover;
      height: 100%;
      min-height: 100%;
    }
    .site-footer .container-fluid {
      padding-top: 0.5rem !important;
      padding-bottom: 0.5rem !important;
    }
    .site-footer p {
      margin-bottom: 0 !important;
      font-size: 0.85rem;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

  <header class="flex-shrink-0 bg-white border-bottom shadow-sm py-2 px-3 px-md-4">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      <a href="/" target="_blank" class="d-inline-flex align-items-center text-decoration-none">
        <img src="/assets/images/benhub.png" alt="BenHub Logo" style="height: 28px; width: auto;">
      </a>
      <a href="/" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Site
      </a>
    </div>
  </header>

  <main class="flex-grow-1 d-flex align-items-center justify-content-center py-3 px-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7">
          <div class="card shadow-sm border-0 overflow-hidden">
            <div class="row g-0">
              <!-- Card Image (visible on md screens and up) -->
              <div class="col-md-5 d-none d-md-block position-relative bg-dark">
                <img src="/assets/images/image1.jpg" alt="BenHub Dining Space" class="w-100 login-split-img">
              </div>
              <!-- Card Body / Login Form -->
              <div class="col-md-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-4 w-100">
                  <div class="mb-3">
                    <p class="section-kicker mb-1">Administration</p>
                    <h1 class="h5 fw-bold mb-1">Sign In</h1>
                    <p class="text-secondary small mb-0">Enter your credentials to access the dashboard.</p>
                  </div>

                  <div id="feedbackMessage"></div>

                  <!-- Login Form -->
                  <form id="loginForm" autocomplete="off">
                    <div class="mb-3">
                      <label for="adUsername" class="form-label small fw-semibold">Username</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" id="adUsername" maxlength="100" class="form-control" required autofocus placeholder="Enter username">
                      </div>
                    </div>
                    <div class="mb-4">
                      <label for="adPassword" class="form-label small fw-semibold">Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="adPassword" maxlength="100" class="form-control" required placeholder="Enter password">
                      </div>
                    </div>
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="site-footer flex-shrink-0">
    <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php"; ?>
  </footer>

  <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());

      fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(response => response.json().then(data => ({status: response.status, body: data})))
      .then(res => {
        if (res.status === 200) {
          window.location.href = '/admin';
        } else {
          const fb = document.getElementById('feedbackMessage');
          fb.innerHTML = `<div class='alert alert-danger alert-dismissible fade show mb-3' role='alert'>
            <strong>Error:</strong> ${res.body.message}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>`;
          setTimeout(() => {
            const alertEl = fb.querySelector('.alert');
            if (alertEl) {
              bootstrap.Alert.getOrCreateInstance(alertEl).close();
            }
          }, 6000);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  </script>
</body>
</html>
