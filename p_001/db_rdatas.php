<?php

require "dbconnection.php";

$reservationDatas = "SELECT * FROM reservation_info ORDER BY reservation_date ASC";
$datasQuery = $dbConnect->prepare($reservationDatas);
$datasQuery->execute();
$dataResults = $datasQuery->get_result();

if ($dataResults->num_rows > 0) {
  while ($dataRow =  $dataResults->fetch_assoc()) {
    echo "<section id='$dataRow[reservation_date]'>
            <tr>
              <td>$dataRow[reservation_id]</td>
              <td>$dataRow[reservation_date]</td>
              <td>$dataRow[reservation_time]</td>
              <td>$dataRow[reservation_floor]</td>
              <td>$dataRow[reservation_table]</td>
              <td>$dataRow[num_guest]</td>
              <td>
                <a href='rdview.php?id=$dataRow[reservation_id]' class='btn btn-success btn-sm'>view</a>
                <a href='rddelete.php?id=$dataRow[reservation_id]' class='btn btn-danger btn-sm'>delete</a>
              </td>
            </tr>
          </section>";
  }
} else {
  echo "<tr>
          <td colspan='7'>No data yet.</td>
        </tr>";;
}

$dbConnect->close();
?>