<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Welcome</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

  <form onsubmit="addTodo()">
    <input type="text" id="todo_text"></input>
    <input type="hidden" id="user_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
    <input type="submit" class="btn btn-primary" value="Add">
  </form>

  <div id="display_area">

  </div>

  <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){
  refreshTodos();

  });
// Refresh todo list
function refreshTodos() {
  var get_user_id = $('#user_id').val();
  $.ajax({
        type: "GET",
        url: "get-todos.php",
        data: {
          'user_id': get_user_id,
        },
        success: function(response){
            $("#display_area").html(response);
            //alert(response);
        }
    });
  };

  // Save todo to db
  function addTodo() {
    var user_id = $('#user_id').val();
    var todo = $('#todo_text').val();
    $.ajax({
      url: 'add-todo.php',
      type: 'POST',
      data: {
        'user_id': user_id,
        'todo': todo,
      },
      success: function(response){
        $('#todo_text').val('');
        refreshTodos();
      }
    });
  };

  //Delete todo from db
  function deleteTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'delete-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
      }
    });
  }


</script>

</body>
</html>
