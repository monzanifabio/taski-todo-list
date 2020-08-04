<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
      <div class="row h-100">
        <div id="signupForm" class="my-auto col-md-4 offset-md-4 mt-5">
          <h2 class="pb-4">Sign Up</h2>
          <form>
              <div class="form-group">
                  <label>Email</label>
                  <input id="email" type="email" name="email" class="form-control" required>
                  <span id="email-help" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label>Password</label>
                  <input id="password" type="password" name="password" class="form-control" required>
                  <span id="password-help" class="help-block"></span>
              </div>
              <div class="form-group">
                  <label>Confirm Password</label>
                  <input id="confirm_password" type="password" name="confirm_password" class="form-control" required>
                  <span id="confirm_password_help" class="help-block"></span>
              </div>
              <div class="form-group">
                  <input type="button" id="register_btn" class="btn btn-primary btn-block" value="Submit">
                  <input type="reset" class="btn btn-default btn-block" value="Reset">
              </div>
              <p>Already have an account? <a href="login.php">Login here</a>.</p>
          </form>
        </div>

        <div id="successform" class="my-auto col-md-4 offset-md-4 mt-5 text-center">
          <h2 class="pb-5">Registration successful</h2>
          <h2><i class="fas fa-check-circle registration"></i></h2>
          <a class="btn btn-light mt-5" href="login.php">Click here to login</a>
        </div>

      </div>
    </div>
    <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
        <script src="vendors/bootstrap-4.5.0/js/popper.min.js"></script>
        <script src="vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('#successform').hide();
  $("#email").focus(function(){
    $("#email-help").text("");
  });
  // Remove password tip when input is back in focus
  $("#password").focus(function(){
    $("#password-help").text("");
  });
  // Remove password checker tip when input is back in focus
  $("#confirm_password").focus(function(){
    $("#confirm_password-help").text("");
  });
  // Check in realtime if the email is already being used or not
  $("#email").change(function(){
    var email = $("#email").val();
    $.ajax({
          type: "POST",
          url: "src/check-email.php",
          data: {
            'email': email,
          },
          success: function(response){
            $('#email-help').text(response);
          }
      });
  });
});
$('#register_btn').click(function() {
  var email = $('#email').val();
  var emailHelp = $('#email-help');
  var password = $('#password').val();
  var passHelp = $('#password-help');
  var confirm_password = $('#confirm_password').val();
  var confirmHelp = $('#confirm_password_help');
  if (email == "") {
    emailHelp.text('Email is missing');
    return false;
  };
  if (emailHelp.html() != "") {
    emailHelp.text('Try another email');
    return false;
  }
  if (password == "") {
    passHelp.text('Please insert a password');
    return false;
  }
  if (password.length < 6) {
    passHelp.text('Your password need to be longer that 6 characters');
    return false;
  }
  if (password != confirm_password) {
    confirmHelp.text('Your password does not match');
    return false;
  };
  $.ajax({
        type: "POST",
        url: "src/reg.php",
        data: {
          'email': email,
          'password': password,
        },
        success: function(response){
          alert('Registered!');
          $('#signupForm').hide();
          $('#successform').show();
        }
    });
    return false;
  });
</script>
</body>
</html>
