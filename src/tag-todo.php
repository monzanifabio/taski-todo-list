<?php
// Include config file
require_once "config/config.php";

$todo_id = $_GET['todo_id'];
$todo_tag = $_GET['getTag'];
$sql = "UPDATE todos SET tag = '$todo_tag' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Tagged";
  header ("Location: index.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
