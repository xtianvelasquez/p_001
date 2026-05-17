<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Administration</title>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

  <div class="container-fluid bg-light py-3 ps-4 shadow-sm">
    <a href="/" target="_blank">
      <img src="/assets/images/benhub.png" alt="BenHub Logo" class="img-fluid" width="100" height="20">
    </a>
  </div>

  <div class="container-lg px-5 px-lg-0 py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <!--card image-->
          <div class="card-img-top">
            <img src="/assets/images/image1.jpg" alt="Photo by Linh Nguyen on Unsplash" class="img-fluid">
          </div>
          <!--card body-->
          <div class="card-body p-5">
            <div id="feedbackMessage"></div>
            <!--login form-->
            <form id="loginForm" autocomplete="off">
              <div class="row mb-4">
                <label for="adUsername">Username</label>
                <input type="text" name="username" id="adUsername" maxlength="100" class="form-control" required>
              </div>
              <div class="row mb-5">
                <label for="adPassword">Password</label>
                <input type="password" name="password" id="adPassword" maxlength="100" class="form-control" required>
              </div>
              <div class="row">
                <button type="submit" class="btn btn-primary px-4">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include __DIR__ . "/../../Frontend/Views/extras/copyright.php"; ?>

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
          document.getElementById('feedbackMessage').innerHTML = `<div class='alert alert-danger alert-dismissible fade show mb-3'>
            <strong>Error:</strong> ${res.body.message}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>`;
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  </script>
</body>
</html>
