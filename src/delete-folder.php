<?php
// Include config file
require_once "../config/config.php";

$todo_id = $_GET['folder_id'];

$sql = "DELETE FROM folders WHERE id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($link);
 ?>
