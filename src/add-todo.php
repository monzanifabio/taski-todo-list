<?php
// Include config file
require_once "../config/config.php";

$todo = mysqli_real_escape_string($link, $_POST['todo']);
$user_id = $_POST['user_id'];
$folder_id = $_POST['folder_id'];

$sql = "INSERT INTO todos (todo, user_id, completed_at, folder_id)
VALUES ('$todo', '$user_id', NULL, '$folder_id')";

if (mysqli_query($link, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
