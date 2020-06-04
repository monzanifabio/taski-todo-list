<?php
// Include config file
require_once "config.php";

$user_id = $_SESSION['id'];
$filter = $_GET['filter'];

if (empty($filter)) {
  $filter = "created_at DESC";
}

//running SQL query
$query ="SELECT * FROM todos WHERE user_id = $user_id AND completed = '0' ORDER BY $filter" ;
$result=mysqli_query($link, $query)
  or die("Failed to load data.");
  // Store the number of retrieved rows
  $isempty = mysqli_num_rows($result);
  // If the number of retrieved rows is equal to 0 then print Nothing otherwise execute the loop
  if ($isempty == 0) {
    echo "<div class='empty'>";
    echo "<h4>🎉 You don't have any task</h4>";
    echo "</div>";
  } else {
  //processing results
  while($row = mysqli_fetch_assoc($result)){
    echo "<li class='list-group-item'>";
    echo "<a href='check-todo.php?todo_id=" . $row['todo_id'] . "' class='button-check'><i class='fas fa-check'></i></a>";
    echo "<a onclick='selectId(this)' class='todo' data-toggle='modal' data-target='#editModal' data-id=" . $row['todo_id'] . ">" . ucfirst($row['todo']) . "</a>";
    echo "<a href='delete-todo.php?todo_id=" . $row['todo_id'] . "' class='button-delete far fa-trash-alt badge-pill'></a>";
    echo "<div class='btn-group dropleft'>";
    echo "<a href='#' class='button-tag tag-" . $row['tag'] . "' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    echo "<i class='fas fa-tag'></i>";
    echo "</a>";
    echo "<div class='dropdown-menu dropdown-left' aria-labelledby='dropdownMenuButton'>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=red' class='dropdown-item tag-red' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=orange' class='dropdown-item tag-orange' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=yellow' class='dropdown-item tag-yellow' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=green' class='dropdown-item tag-green' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=blue' class='dropdown-item tag-blue' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=purple' class='dropdown-item tag-purple' href='#'><i class='fas fa-circle'></i></a>";
    echo "<a href='tag-todo.php?todo_id=" . $row['todo_id'] . "&getTag=grey' class='dropdown-item tag-grey' href='#'><i class='fas fa-circle'></i></a>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
  }
}
 ?>
