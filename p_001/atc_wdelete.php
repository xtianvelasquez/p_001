<?php

require("dbconnection.php");

$tcDescriptions = "SELECT * FROM terms_conditions ORDER BY tc_num ASC";
$descriptionsQuery = $dbConnect->prepare($tcDescriptions);
$descriptionsQuery->execute();
$descriptionsQuery->bind_result($tcNum, $tcTitle, $tcDescriptions);

while ($descriptionsQuery->fetch()) {

  echo "<section id='$tcNum'>
          <div class='row align-items-center mb-2'>
            <div class='col'>
              <h5 class='fw-bold mb-0'> $tcNum . $tcTitle </h5>
            </div>
            <div class='col-auto'>
              <a href='dbatc_wdelete.php?num=$tcNum' class='btn btn-danger btn-sm'>delete</a>
            </div>
          </div>
          <p class='mb-4'> $tcDescriptions </p>
        </section>";
}

$dbConnect->close();
?>