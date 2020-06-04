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

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Tasks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo ucfirst(htmlspecialchars($_SESSION["username"])); ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="reset-password.php">Reset password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <!-- Insert todo on top of the page -->
      <!-- <div class="row">
        <div class="col-md">
        <form action="add-todo.php" method="post">
          <div class="input-group mb-3 input-group-lg">
            <input type="text" name="todo" class="form-control" placeholder="Type something..." aria-describedby="button-addon2" required autofocus autocomplete="off">
            <input type="hidden" name="user_id" value="<?php //echo htmlspecialchars($_SESSION['id']); ?>">
            <div class="input-group-append">
              <input type="submit" class="btn btn-primary" value="Add" id="button-addon2">
            </div>
          </div>
        </form>
      </div>
      </div> -->

        <div class="row">
          <div class="col-md">
            <h2 class="title mb-2">Tasks</h2>
            <span class="badge badge-secondary"><?php include('count-todo.php') ?></span>
            <div class="filters float-right">
              <!-- <span class="filters-text text-uppercase font-weight-bold">Order by</span> -->
              <div class="dropdown d-inline">
                <button class="filters-select dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Order by
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="index.php?filter=created_at DESC">Recent</a>
                  <a class="dropdown-item" href="index.php?filter=created_at ASC">Oldest</a>
                  <a class="dropdown-item" href="index.php?filter=todo">A/Z</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <ul class="list-group">
              <?php include('get-todos.php') ?>
            </ul>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md">
            <h2 class="title mb-2 mt-4">Completed</h2>
            <span class="badge badge-secondary"><?php include('count-completed.php') ?></span>

            <div class="list-group">
              <?php include('get-completed.php') ?>
            </div>
          </div>
        </div>
        <!-- Spacing for bottom navabr -->
        <div class="row mt-5 mb-5">
        </div>

        <nav class="navbar fixed-bottom navbar-light bg-light">
          <form class="form-todo" action="add-todo.php" method="post">
            <div class="input-group mb-3 input-group-lg">
              <input type="text" name="todo" class="form-control" placeholder="Type something..." aria-describedby="button-addon2" required autofocus autocomplete="off">
              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
              <div class="input-group-append">
                <input type="submit" class="btn btn-primary" value="Add" id="button-addon2">
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
              <form id="update" action="update-todo.php" method="post">
                <div class="modal-body">
                  <textarea id="editBox" name="updateTodo" rows="6" class="w-100"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="save">
              </form>
              </div>
            </div>
          </div>
        </div>

        <script>
        function selectId(e) {
          var dataId = e.getAttribute('data-id');
          var content = e.textContent;
          var save = "update-todo.php?todo_id=" + dataId;
          var editBox = document.getElementById('editBox');
          editBox.innerHTML = content;
          document.getElementById('update').setAttribute ('action', save);
        };
        </script>

      </div>
    </div>
    <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script>
        $('.dropdown-menu a').on('click', function(){
        $('.dropdown-toggle').html($(this).html());
        })
        </script>
</body>
</html>
