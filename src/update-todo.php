<?php
// Include config file
require_once "config/config.php";

$todo_id = $_GET['todo_id'];
$updated_todo = mysqli_real_escape_string($link, $_POST['updateTodo']);
$sql = "UPDATE todos SET todo = '$updated_todo' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
  header ("Location: index.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
