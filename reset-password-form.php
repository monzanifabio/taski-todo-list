<?php include('src/reset-password.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
      <div class="row h-100">
        <div class="my-auto col-md-4 offset-md-4 mt-5">
          <h2 class="pb-4">Reset Password</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                  <label>New Password</label>
                  <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                  <span class="help-block"><?php echo $new_password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" class="form-control">
                  <span class="help-block"><?php echo $confirm_password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-primary float-right" value="Submit">
                  <a class="btn btn-link float-right" href="index.php">Cancel</a>
              </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html>
