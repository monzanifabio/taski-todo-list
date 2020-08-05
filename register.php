<?php include('src/register.php') ?>
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
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                  <label>Email</label>
                  <input id="email" type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                  <span id="email-help" class="help-block"><?php echo $email_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>Password</label>
                  <input id="password" type="password" name="password" class="form-control" value="<?php echo $password; ?>" required>
                  <span id="password-help" class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>Confirm Password</label>
                  <input id="confirm_password" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required>
                  <span id="confirm_password_help" class="help-block"><?php echo $confirm_password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" id="register_btn" class="btn btn-primary btn-block" value="Submit">
                  <input type="reset" class="btn btn-default btn-block" value="Reset">
              </div>
              <p>Already have an account? <a href="login.php">Login here</a>.</p>
          </form>
        </div>

        <!-- <div id="successform" class="my-auto col-md-4 offset-md-4 mt-5 text-center">
          <h2 class="pb-5">Registration successful</h2>
          <h2><i class="fas fa-check-circle registration"></i></h2>
          <a class="btn btn-light mt-5" href="login.php">Click here to login</a>
        </div> -->

      </div>
    </div>
    <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
        <script src="vendors/bootstrap-4.5.0/js/popper.min.js"></script>
        <script src="vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>
        <!-- <script src="js/register.js"></script> -->
</body>
</html>
