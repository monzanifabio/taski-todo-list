<?php
// Include config file
require_once "../config/config.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

$sql = "INSERT INTO users (email, password)
VALUES ('$email', '$param_password')";

if (mysqli_query($link, $sql)) {
  echo "New user created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
