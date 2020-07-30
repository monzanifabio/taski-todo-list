<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];

//running SQL query
$query ="SELECT DISTINCT labelName, labelColor FROM todos WHERE user_id = $user_id";
$result=mysqli_query($link, $query)
  or die("Failed to load folders.");
  // Store the number of retrieved rows
  $isempty = mysqli_num_rows($result);
  // If the number of retrieved rows is equal to 0 then print Nothing otherwise execute the loop
  if ($isempty == 0) {
    // echo "<div class='empty'>";
    // echo "<h4>🎉 You don't have any task</h4>";
    // echo "</div>";
  } else {
  //processing results
  while($row = mysqli_fetch_assoc($result)){
    if ($row['labelName'] != "") {
      echo "<a onclick='copyLabel(this)' id='" . $row['labelColor'] . "' class='label label-lg label-" . $row['labelColor'] . "'>" . $row['labelName'] . "</a>";
    }
  }
}
 ?>
