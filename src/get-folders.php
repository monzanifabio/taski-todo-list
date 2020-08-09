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
    echo "<li class='list-group-item list-group-item-action bg-light'>";
    echo "<p class='mb-2 pointer'><i class='fas fa-folder'></i> " . ucfirst($row['folder_name']) . "</p>";
    echo "<span class='badge badge-secondary'></span>";
    echo "<div class='float-right'>";
    echo "<div class='dropdown d-inline'>";
    echo "<button class='filters-select' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    echo "<i class='fas fa-ellipsis-v'></i></button>";
    echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton'>";
    echo "<p class='dropdown-item' id='" . $row['id'] . "' onclick='deleteFolder(this)'>Delete</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
  }
}
 ?>
