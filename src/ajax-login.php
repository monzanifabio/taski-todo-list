<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: test.php");
    exit;
}

// Include config file
require_once "../config/config.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

$sql = "SELECT user_id, email, password FROM users WHERE email = '$email'";


if (mysqli_query($link, $sql)) {
  $password = $row['password'];
  if ($password == $param_password) {
    // Password is correct, so start a new session
    session_start();

    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["id"] = $id;
    $_SESSION["email"] = $email;
  }
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
