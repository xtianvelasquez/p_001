<?php

require("dbconnection.php");

$tc_description = "SELECT * FROM terms_conditions ORDER BY tc_num ASC";
$tcdQuery = $dbConnect->prepare($tc_description);
$tcdQuery->execute();
$tcdResults = $tcdQuery->get_result();

if ($tcdResults->num_rows > 0) {
  while ($tcdRow = $tcdResults->fetch_assoc()) {
    echo "<section id='tc$tcdRow[tc_num]'>
            <div class='row align-items-center mb-2'>
              <div class='col'>
                <p class='fw-bold mb-0'>$tcdRow[tc_num]. $tcdRow[tc_title]</p>
              </div>
              <p class='mb-4'>$tcdRow[tc_description]</p>
            </div>
          </section>";
  }
}

$dbConnect->close();
?>