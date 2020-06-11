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
    <link rel="stylesheet" href="vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <p>Hi, <?php echo ucfirst(htmlspecialchars($_SESSION["username"])); ?></p>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto">
        <a class="dropdown-item" href="reset-password.php">Reset password</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php">Logout</a>
      </ul>
    </div>
  </nav>

  <div class="container">

    <div class="row">
      <div class="col-md">
        <h2 class="title mb-2">Tasks</h2>
        <span class="badge badge-secondary" id="count_todos"></span>
        <div class="filters float-right">
          <div class="dropdown d-inline">
            <button class="filters-select dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Order by
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <p class="dropdown-item" id="created_at desc" onclick="orderBy(this)">Recent</p>
              <p class="dropdown-item" id="created_at asc" onclick="orderBy(this)">Oldest</p>
              <p class="dropdown-item" id="todo" onclick="orderBy(this)">A/Z</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md">
        <ul class="list-group" id="display_area">
        </ul>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md">
        <h2 class="title mb-2">Completed</h2>
        <span class="badge badge-secondary" id="count_completed"></span>
        <div class="filters float-right">
          <p onclick="deleteCompleted()" class="filters-select">Clear all</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md">
        <div class="list-group" id="completed_area">
        </div>
      </div>
    </div>
    <!-- Spacing for bottom navabr -->
    <div class="row mt-5 mb-5">
    </div>

  </div>

  <nav class="navbar fixed-bottom navbar-light bg-light">
    <form class="form-todo">
      <div class="input-group mb-3 input-group-lg">
        <input id="todo_text" type="text" name="todo" class="form-control" placeholder="Type something..." aria-describedby="button-addon2" required autofocus autocomplete="off">
        <input id="user_id" type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
        <div class="input-group-append">
          <input type="submit" class="btn btn-primary" value="Add" id="add_todo_btn">
        </div>
      </div>
    </form>
  </nav>

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
        <form>
          <div class="modal-body">
            <textarea id="editBox" rows="6" class="w-100"></textarea>
            <input type="hidden" id="todo_id" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Save" id="save_todo_btn">
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
      <script src="vendors/bootstrap-4.5.0/js/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>

<script>
// Execute when the page load
$(document).ready(function(){
  refreshTodos(); // Get latest todos
  refreshCompleted(); // Get latest completed todos
  countTodos(); // Get the number of todos
  countCompleted(); // Get the number of completed todos
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

  //Count todos
  function countTodos() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/count-todo.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#count_todos").html(response);
          }
      });
    };

  //Count completed
  function countCompleted() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/count-completed.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#count_completed").html(response);
          }
      });
    };

  // Filter todo by
  function orderBy(elem) {
    var get_user_id = $('#user_id').val();
    var filter = $(elem).attr('id');
    $.ajax({
      url: 'src/get-todos.php',
      type: 'GET',
      data: {
        'user_id': get_user_id,
        'filter': filter,
      },
      success: function(response){
        $("#display_area").html(response);
      }
    });
  };

  // Add todo to database
  $('#add_todo_btn').click(function(){
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
        countTodos();
      }
    });
    return false;
  });

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
        countTodos();
      }
    });
  };

  // Delete all completed todos
  function deleteCompleted() {
    var user_id = $('#user_id').val();
    $.ajax({
      url: 'src/delete-completed.php',
      type: 'GET',
      data: {
        'user_id': user_id,
      },
      success: function(response){
        refreshCompleted();
        countCompleted();
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
  $('#save_todo_btn').click(function() {
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
    return false;
  });

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
        countTodos();
        countCompleted();
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
        countTodos();
        countCompleted();
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
      }
    });
  };
</script>

</body>
</html>
