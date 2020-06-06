<?php
// Include config file
require_once "config/config.php";

$todo_id = $_GET['todo_id'];
$sql = "UPDATE todos SET completed='0', completed_at= NULL WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Updated";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
