<?php
// Include config file
require_once "../config/config.php";

$user_id = $_GET['user_id'];
$folder_id = $_GET['folder_id'];

$query = "SELECT * FROM todos WHERE completed = '1' AND user_id = $user_id AND folder_id = $folder_id";
$result = mysqli_query($link, $query)
  or die("Failed to load data.");

  $count = mysqli_num_rows($result);

echo $count;
?>
