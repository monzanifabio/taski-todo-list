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
        url: "src/register.php",
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
