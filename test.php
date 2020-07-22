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

    <title>Tasks</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <p class="small navbar-nav ml-auto"></p>
      <div class="dropdown">
        <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo htmlspecialchars($_SESSION["email"]); ?>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
          <!-- <a class="dropdown-item btn btn-light" data-toggle="modal" data-target="#folderModal">New folder</a> -->
          <a class="small dropdown-item" href="reset-password.php">Reset password</a>
          <!-- <div class="dropdown-divider"></div> -->
          <a class="small dropdown-item" href="logout.php">Logout</a>
        </div>
      </div>
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
    <!-- Display tasks -->
    <div class="row">
      <div class="col-md">
        <ul class="list-group" id="display_area">
        </ul>
      </div>
    </div>

    <div class="row mt-4" id="display_folders">

    </div>

    <div class="row mt-4">
      <div class="col-md">
        <h2 class="title mb-2">Completed</h2>
        <span class="badge badge-secondary" id="count_completed"></span>
        <div class="filters float-right">
          <p id="clear_all" onclick="deleteCompleted()" class="filters-select"><i class="fas fa-trash-alt"></i> Clear all</p>
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

  <!-- Folder Modal -->
  <div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form>
          <div class="modal-body">
            <div class="input-group mb-3 input-group-lg">
              <input id="folder_name" type="text" class="form-control border" placeholder="Name your folder" required autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Create" id="create_folder">
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Label Modal -->
  <div class="modal fade" id="labelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New label</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="labelForm">
          <div class="modal-body">
              <div class="form-group mb-3 input-group-lg">
                <input id="label_name" type="text" class="form-control border" maxlength="48" placeholder="Name your label" required autocomplete="off">
                <span id="label_warning" class="help-block"></span>
                <small class="form-text text-muted">Max 48 characters</small>
                <input type="hidden" id="label_todo_id" value="">
              </div>
            <div class="label-container d-flex flex-row justify-content-between">
              <input class="red" type="radio" id="red" name="labelColor" value="red">
              <input class="orange" type="radio" id="orange" name="labelColor" value="orange">
              <input class="yellow" type="radio" id="yellow" name="labelColor" value="yellow">
              <input class="green" type="radio" id="green" name="labelColor" value="green">
              <input class="blue" type="radio" id="blue" name="labelColor" value="blue">
              <input class="purple" type="radio" id="purple" name="labelColor" value="purple">
              <input class="gray" type="radio" id="gray" name="labelColor" value="gray" checked="checked">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Create" id="create_label">
        </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
      <script src="vendors/bootstrap-4.5.0/js/popper.min.js"></script>
      <script src="vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>

<script>
// Execute when the page load
$(document).ready(function(){
  refreshTodos(); // Get latest todos
  refreshCompleted(); // Get latest completed todos
  refreshFolders(); // Get latest folders
  countTodos(); // Get the number of todos
  countCompleted(); // Get the number of completed todos
  clearAll();
  });

  // Show clear all button?
  function clearAll() {
    var todos_completed = $('#count_completed').text();
    if (todos_completed == 0) {
      $('#clear_all').hide();
    } else {
      $('#clear_all').show();
    }
  };

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

  //Refresh folders
  function refreshFolders() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/get-folders.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#display_folders").html(response);
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
              clearAll();
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

  //Create folders
  $('#create_folder').click(function() {
    var user_id = $('#user_id').val();
    var folder_name = $('#folder_name').val();
    $.ajax({
      url: 'src/create-folder.php',
      type: 'POST',
      data: {
        'user_id': user_id,
        'folder_name': folder_name,
      },
      success: function(response){
        $('#folder_name').val('');
        $('#folderModal').modal('hide');
        refreshFolders();
        refreshTodos();
        countTodos();
      }
    });
    return false;
  });

  //Create label modal launcher
  function labelTodo(elem) {
    var todo_id = $(elem).attr('id');
    $('#labelModal').modal();
    $('#label_todo_id').val(todo_id);
  }

  //Create label
  $('#create_label').click(function() {
    var todo_id = $('#label_todo_id').val();
    var label_name = $('#label_name').val();
    var label_color = $('input[name=labelColor]:checked', '#labelForm').val()
    if (label_name == "") {
      $('#label_warning').text("Don't forget to name your label");
    } else {
      $.ajax({
        url: 'src/add-label.php',
        type: 'POST',
        data: {
          'todo_id': todo_id,
          'label_name': label_name,
          'label_color': label_color,
        },
        success: function(response){
          $('#label_name').val('');
          $('#label_warning').text('')
          $('#labelModal').modal('hide');
          refreshFolders();
          refreshTodos();
          countTodos();
        }
      });
      return false;
    }
  });

  //Delete todo from database
  function deleteTodo(elem) {
    var todo_id = $(elem).attr('id');
    var user_id = $('#user_id').val();
    $.ajax({
      url: 'src/delete-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
        'user_id': user_id,
      },
      success: function(response){
        refreshTodos();
        countTodos();
      }
    });
  };

  //Delete label from todo
  function deleteLabel(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/delete-label.php',
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

  // Delete folder from database
  function deleteFolder(elem) {
    var folder_id = $(elem).attr('id');
    $.ajax({
      url: 'src/delete-folder.php',
      type: 'GET',
      data: {
        'folder_id': folder_id,
      },
      success: function(response){
        refreshFolders();
        refreshTodos();
        countTodos();
      }
    });
  }

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
        clearAll();
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
        clearAll();
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
        clearAll();
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
