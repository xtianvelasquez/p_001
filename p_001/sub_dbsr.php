<?php

require("dbconnection.php");

if (isset($_GET['rid'])) {
  $rid = $_GET['rid'];

  try {
    $reference = "SELECT * FROM reservation_info JOIN customer_info WHERE reservation_id = ? AND customer_id = ? LIMIT 1";
    $referenceQuery = $dbConnect->prepare($reference);
    $referenceQuery->bind_param("ii", $rid, $rid);
    $referenceQuery->execute();
    $r_queryResults = $referenceQuery->get_result();

    if ($r_queryResults->num_rows > 0) {
      while ($r_queryRow =  $r_queryResults->fetch_assoc()) {
        echo "<div class='table-responsive-sm'>
              <table class='table table-bordered'>
                <tr>
                  <th>First Name</th>
                  <td>$r_queryRow[first_name]</td>
                </tr>
                <tr>
                  <th>Last Name</th>
                  <td>$r_queryRow[last_name]</td>
                </tr>
                <tr>
                  <th>Age</th>
                  <td>$r_queryRow[age]</td>
                </tr>
                <tr>
                  <th>Contact Number</th>
                  <td>$r_queryRow[contact_num]</td>
                </tr>
                <tr>
                  <th>Email Address</th>
                  <td>$r_queryRow[email_add]</td>
                </tr>
                <tr>
                  <th>Reservation Date</th>
                  <td>$r_queryRow[reservation_date]</td>
                </tr>
                <tr>
                  <th>Reservation Time</th>
                  <td>$r_queryRow[reservation_time]</td>
                </tr>
                <tr>
                  <th>Guest/s</th>
                  <td>$r_queryRow[num_guest]</td>
                </tr>
                <tr>
                  <th>Reservation Floor</th>
                  <td>$r_queryRow[reservation_floor]</td>
                </tr>
                <tr>
                  <th>Reservation Table</th>
                  <td>$r_queryRow[reservation_table]</td>
                </tr>
              </table>
            </div>";
      }
    }
  } catch (exception $e) {
    // Handle the exception (log, display an error message, etc.)
    echo "Error: " . $e->getMessage();
  } finally {
    // Close database connection
    if ($dbConnect->ping()) {
      $dbConnect->close();
    }
  }
}
?>