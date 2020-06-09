<?php
// Include config file
require_once "config/config.php";

$todo_id = $_GET['todo_id'];
$sql = "DELETE FROM todos WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
  header ("Location: index.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
