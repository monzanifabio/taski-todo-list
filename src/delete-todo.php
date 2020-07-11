<?php
// Include config file
require_once "../config/config.php";

$todo_id = $_GET['todo_id'];
$user_id = $_GET['user_id'];

// Move todo to a new table
$sql = "INSERT INTO removed (todo, user_id) SELECT todo, user_id FROM todos WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Moved to new table<br>";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Delete todo from current table 
$sql = "DELETE FROM todos WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "Deleted";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($link);
 ?>
