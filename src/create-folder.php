<?php
// Include config file
require_once "../config/config.php";

$folder_name = mysqli_real_escape_string($link, $_POST['folder_name']);
$user_id = $_POST['user_id'];

$sql = "INSERT INTO folders (folder_name, user_id)
VALUES ('$folder_name', '$user_id')";

if (mysqli_query($link, $sql)) {
  echo "New folder created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
