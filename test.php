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
        <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
              <p class="dropdown-item" id="labelName" onclick="orderBy(this)">Label name</p>
              <p class="dropdown-item" id="labelColor" onclick="orderBy(this)">Label color</p>
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
            <div id="display_labels"></div>
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
      <script src="js/logic.js"></script>

</body>
</html>
