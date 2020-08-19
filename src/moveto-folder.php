<?php
// Include config file
require_once "../config/config.php";

$todo_id = $_GET['todo_id'];
$folder_id = $_GET['folder_id'];
$sql = "UPDATE todos SET folder_id = '$folder_id' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Moved to folder";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
