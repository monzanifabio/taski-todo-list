<?php
// Include config file
require_once "config.php";

$todo_id = $_POST['todo_id'];
$updated_todo = mysqli_real_escape_string($link, $_POST['updated_todo']);
$sql = "UPDATE todos SET todo = '$updated_todo' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Updated";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
