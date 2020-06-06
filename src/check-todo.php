<?php
// Include config file
require_once "../config/config.php";

date_default_timezone_set('Europe/London');
$timestamp = date("Y-m-d H:i:s");
$todo_id = $_GET['todo_id'];
$sql = "UPDATE todos SET completed='1', completed_at = '$timestamp'  WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Updated";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
