<?php
// Include config file
require_once "config/config.php";

$user_id = $_SESSION['id'];

$query = "SELECT * FROM todos WHERE completed = '0' AND user_id = $user_id";
$result = mysqli_query($link, $query)
  or die("Failed to load data.");

  $count = mysqli_num_rows($result);

echo $count;
?>
