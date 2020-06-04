<?php
// Include config file
require_once "config.php";

$todo = mysqli_real_escape_string($link, $_POST['todo']);
$user_id = $_POST['user_id'];

$sql = "INSERT INTO todos (todo, user_id)
VALUES ('$todo', '$user_id')";

if (mysqli_query($link, $sql)) {
  echo "New record created successfully";
  header("location: index.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
