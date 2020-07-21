<?php
// Include config file
require_once "../config/config.php";

$todo_id = $_GET['todo_id'];

$sql = "UPDATE todos SET labelName = '', labelColor = '' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Label deleted";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($link);
 ?>
