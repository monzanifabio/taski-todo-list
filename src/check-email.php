<?php
// Include config file
require_once "../config/config.php";

$email = $_POST['email'];

$query = "SELECT * FROM users WHERE email ='$email'";

$result = mysqli_query($link, $query)
  or die("Failed to load data.");

if(mysqli_num_rows($result) > 0){
    echo "This email is already being used";
}

mysqli_close($link);
 ?>
