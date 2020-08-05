$('#login_btn').click(function() {
  var email = $('#email').val();
  var emailHelp = $('#email-help');
  var password = $('#password').val();
  var passHelp = $('#password-help');
  //Check if email is filled
  if (email == "") {
    emailHelp.text('Email is missing');
    return false;
  };
  //Check if password is filled
  if (password == "") {
    passHelp.text('Please insert a password');
    return false;
  }

  $.ajax({
        type: "POST",
        url: "src/login.php",
        data: {
          'email': email,
          'password': password,
        },
        success: function(response){
          passHelp.text(response);
          alert('Login!');
          window.location = 'test.php';
        }
    });
  });
