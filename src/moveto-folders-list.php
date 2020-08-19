<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];

//running SQL query
$query ="SELECT * FROM folders WHERE user_id = $user_id";
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
    echo "<li class='list-group-item list-group-item-action'>";
    echo "<p id='0' class='mb-2 pointer font-weight-light' onclick='moveto(this)'><img class='align-bottom' src='img/folder-alt.svg' height='25'> All</p>";
    echo "</li>";
  //processing results
  while($row = mysqli_fetch_assoc($result)){
    echo "<li class='list-group-item list-group-item-action align-items-baseline'>";
    echo "<p id='" . $row['id'] . "' class='mb-2 pointer font-weight-light' onclick='moveto(this)'><img class='align-bottom' src='img/folder-alt.svg' height='25'> " . ucfirst($row['folder_name']) . "</p>";
    echo "<div class='float-right'>";
    echo "<span class='badge badge-light font-weight-light'>";


    $sql = "SELECT * FROM todos WHERE completed = '0' AND user_id = $user_id";

    $results = mysqli_query($link, $sql)
      or die("Failed to load data.");

    echo "</span>";

    echo "</div>";
    echo "</li>";
  }
}
 ?>
