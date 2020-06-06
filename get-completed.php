<?php
// Include config file
require_once "config.php";

$user_id = $_GET['user_id'];

//running SQL query
$query ="SELECT * FROM todos WHERE user_id = $user_id AND completed = '1'" ;
$result=mysqli_query($link, $query)
  or die("Failed to load data.");
// Store the number of retrieved rows
$isempty = mysqli_num_rows($result);
// If the number of retrieved rows is equal to 0 then print Nothing otherwise execute the loop
if ($isempty == 0) {
  echo "<h4 class='empty'>👀 You don't have any completed task...</h4>";
} else {
//processing results
while($row = mysqli_fetch_assoc($result)) {
    echo "<li class='list-group-item completed'>";
    echo "<a onclick='undoTodo(this)' id='" . $row['todo_id'] . "' class='button-undo fas fa-undo-alt'></a>";
    echo "<p class='text-crossed'>" . $row['todo'] . "</p>";
    echo "</li>";
  }
}
 ?>
