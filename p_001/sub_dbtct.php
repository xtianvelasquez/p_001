<?php

require("dbconnection.php");

$tc_title = "SELECT tc_num, tc_title FROM terms_conditions ORDER BY tc_num ASC";
$tctQuery = $dbConnect->prepare($tc_title);
$tctQuery->execute();
$tctResults = $tctQuery->get_result();

if ($tctResults->num_rows > 0) {
  while ($tctRow = $tctResults->fetch_assoc()) {
    echo "<ul class='mb-0'>
            <li><a href='#tc$tctRow[tc_num]' class='text-decoration-none'>$tctRow[tc_title]</a></li>
          </ul>";
  }
} else {
  echo "<ul class='mb-0'>
            <li>no data yet.</li>
        </ul>";
}

$dbConnect->close();
?>