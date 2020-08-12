<?php
// Include config file
require_once "../config/config.php";

$folder_id = $_POST['folder_id'];
$folder_name = mysqli_real_escape_string($link, $_POST['folder_name']);
$sql = "UPDATE folders SET folder_name = '$folder_name' WHERE id = '$folder_id'";

if (mysqli_query($link, $sql)) {
  echo "Folder updated";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($link);
 ?>
