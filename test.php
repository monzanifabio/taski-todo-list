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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <form onsubmit="addTodo()">
    <input type="text" id="todo_text"></input>
    <input type="hidden" id="user_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
    <input type="submit" class="btn btn-primary" value="Add">
  </form>

  <div id="display_area"></div>

  <div id="completed_area"></div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form onsubmit="updateTodo()">
          <div class="modal-body">
            <textarea id="editBox" rows="6" class="w-100"></textarea>
            <input type="hidden" id="todo_id" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Save">
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script>
// Execute when the page load
$(document).ready(function(){
  refreshTodos(); // Get latest todos
  refreshCompleted(); // Get latest completed todos
  });

// Refresh todo list
function refreshTodos() {
  var get_user_id = $('#user_id').val();
  $.ajax({
        type: "GET",
        url: "src/get-todos.php",
        data: {
          'user_id': get_user_id,
        },
        success: function(response){
            $("#display_area").html(response);
        }
    });
  };

  //Refresh completed todo list
  function refreshCompleted() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/get-completed.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#completed_area").html(response);
          }
      });
  };

  // Add todo to database
  function addTodo() {
    var user_id = $('#user_id').val();
    var todo = $('#todo_text').val();
    $.ajax({
      url: 'src/add-todo.php',
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

  //Delete todo from database
  function deleteTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/delete-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
      }
    });
  };

  //Edit todo into modal
  function editTodo(elem) {
    var todo_id = $(elem).attr('id');
    var get_todo_text = $(elem).text();
    $('#editModal').modal();
    $('#todo_id').val(todo_id);
    $('#editBox').val(get_todo_text);
  };

  //Update todo
  function updateTodo() {
    var todo_id = $('#todo_id').val();
    var updated_todo = $('#editBox').val();
    $.ajax({
      url: 'src/update-todo.php',
      type: 'POST',
      data: {
        'todo_id': todo_id,
        'updated_todo': updated_todo,
      },
      success: function(response){
        $('#editModal').modal('hide');
        refreshTodos();
      }
    });
  };

  //Check todo to completed
  function checkTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/check-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
        refreshCompleted();
      }
    });
  };

  //Undo todo from completed
  function undoTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/undo-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
        refreshCompleted();
      }
    });
  };

  //Add a color tag to the todo
  function tagTodo(elem) {
    var todo_id = $(elem).attr('id');
    var todo_tag = $(elem).attr('name');
    $.ajax({
      url: 'src/tag-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
        'todo_tag': todo_tag,
      },
      success: function(response){
        refreshTodos();
        refreshCompleted();
      }
    });
  };
</script>

</body>
</html>
