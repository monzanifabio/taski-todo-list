<?php
// Include config file
require_once "../config/config.php";

$label_name = mysqli_real_escape_string($link, $_POST['label_name']);
$todo_id = $_POST['todo_id'];
$label_color = $_POST['label_color'];

$sql = "UPDATE todos SET labelName = '$label_name', labelColor = '$label_color' WHERE todo_id = '$todo_id'";

if (mysqli_query($link, $sql)) {
  echo "New label created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
