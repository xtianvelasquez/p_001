<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BenHub: Reservation</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <?php
  include __DIR__ . "/extras/header.php";
  include __DIR__ . "/extras/nav_index.php";
  ?>

  <main id="reservation" class="bg-light px-5 px-lg-0 py-5 my-5">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-lg-8 p-4 border border-1 border-secondary">
          
          <div id="feedbackMessage"></div>

          <p class="lead mb-4">Please fill out this reservation form:</p>
          <form id="reservationForm" autocomplete="off">
            <!-- firstName -->
            <div class="row mb-4">
              <div class="col">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" maxlength="100" class="form-control" required>
              </div>
              <!-- lastName -->
              <div class="col">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" maxlength="100" class="form-control" required>
              </div>
              <!-- age -->
              <div class="col-auto">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" min="18" max="80" class="form-control" required>
              </div>
            </div>

            <!-- contactNum -->
            <div class="row mb-4">
              <div class="col">
                <label for="contactNum">Contact Number</label>
                <div class="input-group">
                  <span class="input-group-text">+63</span>
                  <input type="text" name="contactNum" id="contactNum" pattern="\d{10}" minlength="10" maxlength="10" class="form-control" placeholder="**********" required>
                </div>
              </div>
              <!-- emailAdd -->
              <div class="col">
                <label for="emailAdd">Email Address</label>
                <input type="email" name="emailAdd" id="emailAdd" maxlength="100" class="form-control" placeholder="info@example.com" required>
              </div>
            </div>

            <!-- reserveDate -->
            <div class="row mb-4">
              <div class="col">
                <label for="reserveDate">Select date</label>
                <input type="date" name="reserveDate" id="reserveDate" class="form-control" required>
                <script language="javascript">
                  var date = new Date();
                  var year = date.getUTCFullYear();
                  var month = date.getMonth() + 1;
                  if (month < 10) month = '0' + month;
                  var day = date.getDate() + 1;
                  if (day < 10) day = '0' + day;
                  var restrictedDate = year + "-" + month + "-" + day;
                  document.getElementById("reserveDate").setAttribute('min', restrictedDate);
                </script>
              </div>
              <!-- reserveTime -->
              <div class="col">
                <label for="reserveTime">Select time</label>
                <select name="reserveTime" id="reserveTime" class="form-select">
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
              <!-- numGuest -->
              <div class="col-auto">
                <label for="numGuest">Guest/s</label>
                <input type="number" name="numGuest" id="numGuest" min="1" max="13" class="form-control" required>
              </div>
            </div>

            <!-- reserveFloor -->
            <div class="row mb-3">
              <div class="col">
                <label for="reserveFloor">Select floor</label>
                <select name="reserveFloor" id="reserveFloor" class="form-select">
                  <option value="Floor 1">Floor 1</option>
                  <option value="Floor 2">Floor 2</option>
                  <option value="Floor 3">Floor 3</option>
                </select>
              </div>
              <!-- reserveTable -->
              <div class="col">
                <label for="reserveTable">Select table</label>
                <select name="reserveTable" id="rTable" class="form-select">
                  <option value="Table 1">Table 1</option>
                  <option value="Table 2">Table 2</option>
                  <option value="Table 3">Table 3</option>
                  <option value="Table 4">Table 4</option>
                  <option value="Table 5">Table 5</option>
                  <option value="Table 6">Table 6</option>
                  <option value="Table 7">Table 7</option>
                  <option value="Table 8">Table 8</option>
                  <option value="Table 9">Table 9</option>
                  <option value="Table 10">Table 10</option>
                </select>
              </div>
            </div>
            <!-- agreement -->
            <div class="text-center mb-5">
              <input type="checkbox" id="checkbox" required>
              <label for="checkbox">I accept the <span class="text-primary" role="button" data-bs-target="#tc_modal" data-bs-toggle="modal">terms and conditions</span>.</label>
            </div>
            <!-- submission -->
            <div class="text-center">
              <button type="submit" class="btn btn-primary py-2 px-5">Reserve</button>
            </div>
          </form>

        </div>
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

  <script src="assets/bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
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
        const feedback = document.getElementById('feedbackMessage');
        if (res.status === 201) {
          feedback.innerHTML = `<div class='alert alert-success alert-dismissible fade show mb-4'>
            <span><strong>Success!</strong> ${res.body.message}</span>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>`;
          this.reset();
        } else {
          feedback.innerHTML = `<div class='alert alert-danger alert-dismissible fade show mb-4'>
            <span><strong>Sorry!</strong> ${res.body.message}</span>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>`;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the reservation.');
      });
    });
  </script>
</body>
</html>
