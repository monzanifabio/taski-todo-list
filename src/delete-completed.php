<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];

$sql = "DELETE FROM todos WHERE completed = '1' AND user_id = '$user_id'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
