<?php
// Include config file
require_once "../config/config.php";

$sql = "DELETE FROM todos WHERE completed = '1'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
