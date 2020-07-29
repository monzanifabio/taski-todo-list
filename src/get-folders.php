<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];
$filter = $_GET['filter'];

if (empty($filter)) {
  $filter = "created_at DESC";
}

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
  //processing results
  while($row = mysqli_fetch_assoc($result)){
    echo "<div class='col-md-12'>";
    echo "<h2 class='title mb-2'>" . ucfirst($row['folder_name']) . "</h2>";
    echo "<span class='badge badge-secondary'></span>";
    echo "<div class='filters float-right'>";
    echo "<div class='dropdown d-inline'>";
    echo "<button class='filters-select dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    echo "Options</button>";
    echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton'>";
    echo "<p class='dropdown-item' id='" . $row['id'] . "' onclick='deleteFolder(this)'>Delete</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}
 ?>
