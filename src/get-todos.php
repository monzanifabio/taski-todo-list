<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];
$filter = $_GET['filter'];
$folder_id = $_GET['folder_id'];

if (empty($filter)) {
  $filter = "created_at DESC";
}

if (empty($folder_id)) {
  $query ="SELECT * FROM todos WHERE user_id = $user_id AND completed = '0' ORDER BY $filter" ;
} else {
  $query ="SELECT * FROM todos WHERE user_id = $user_id AND completed = '0' AND folder_id = $folder_id ORDER BY $filter" ;
}

//running SQL query
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
    echo "<a onclick='checkTodo(this)' id='" . $row['todo_id'] . "' class='button-check'><i class='fas fa-check'></i></a>";
    echo "<div class='todo-container'>";
    echo "<a onclick='editTodo(this)' class='todo' id='" . $row['todo_id'] . "'>" . ucfirst($row['todo']) . "</a>";
    // echo "<input id='" . $row['todo_id'] . "' class='form-control edit hidden' type='text' value='" . ucfirst($row['todo']) . "'>";
    echo "<textarea id='" . $row['todo_id'] . "' class='form-control edit hidden' type='text'>" . ucfirst($row['todo']) . "</textarea>";
    echo "<button type='submit' id='" . $row['todo_id'] . "' class='btn btn-sm btn-primary hidden float-right' onclick='updateTodo(this)'><i class='fas fa-check'></i></button>";
    echo "<button id='" . $row['todo_id'] . "' class='btn btn-sm btn-outline-light hidden float-right' onclick='dismiss(this)'><i class='fas fa-times'></i></button>";

    if ($row['labelName'] != "") {
      echo "<p class='label label-" . $row['labelColor'] . "'>" . $row['labelName'] . "<a onclick='deleteLabel(this)' class='remove-label' id='" . $row['todo_id'] . "'><span aria-hidden='true'>&times;</span></a></p>";
    }
    echo "</div>";
    echo "<div class='options'>";
    echo "<a onclick='movetoModal(this)' id='" . $row['todo_id'] . "' class='button-folder far fa-folder badge-pill'></a>";
    echo "<a onclick='deleteTodo(this)' id='" . $row['todo_id'] . "' class='button-delete far fa-trash-alt badge-pill'></a>";
    if ($row['labelName'] == "") {
      echo "<a onclick='labelTodo(this)' id='" . $row['todo_id'] . "' class='button-label fas fa-tag badge-pill'></a>";
    }
    echo "</div>";
    // echo "<div class='btn-group dropleft'>";
    // echo "<a href='#' class='button-tag tag-" . $row['tag'] . "' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    // echo "<i class='fas fa-circle'></i>";
    // echo "</a>";
    // echo "<div class='dropdown-menu dropdown-left' aria-labelledby='dropdownMenuButton'>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='red' class='dropdown-item tag-red'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='orange' class='dropdown-item tag-orange'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='yellow' class='dropdown-item tag-yellow'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='green' class='dropdown-item tag-green'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='blue' class='dropdown-item tag-blue'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='purple' class='dropdown-item tag-purple'><i class='fas fa-circle'></i></button>";
    // echo "<button onclick='tagTodo(this)' id='" . $row['todo_id'] . "' name='grey' class='dropdown-item tag-grey'><i class='fas fa-circle'></i></button>";
    // echo "</div>";
    echo "</div>";
    echo "</li>";
  }
}
 ?>
