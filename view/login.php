<!DOCTYPE html>
<html>
<head>
    <title>C$75 Finance</title>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
    <script type='text/javascript'>
      function validateForm()
      {
        isValid = true;

        // Check if email address was correctly entered (min=6: x@x.to)
        emailField = $("input[name=email]");
        if (emailField.val().length < 6) {
          isValid = false;
          alert("not a valid email" + emailField.val().length());
        }

        // Password confirmation
        passField = $("input[name=password]");
        confirmPassField = $("input[name=confirm-password]");
        if (confirmPassField.val() == passwordField.val()) {
          isValid = false;
          alert("passwords do not match");
        }

        return isValid;
      }

      // set the focus to the email field (located by id attribute)
      $("input[name=email]").focus();
    </script>
</head>
<body>
<div class="container">
<form method="POST" action="login" onsubmit="return validateForm();">
    E-mail address: <input type="text" name="email" /><br />
    Password: <input type="password" name="password" /><br />
	<input type="submit" value="Login" />
</form>

<br />

<h3>Or register for an account:</h3>
<form method="POST" action="register" onsubmit="return validateForm();">
    E-mail address: <input type="text" name="email" /><br />
    Password: <input type="password" name="password" /><br />
    Confirm password: <input type="password" name="confirm-password" /><br />
		First name: <input type="text" name="first_name" /><br />
		Last name: <input type="text" name="last_name" /><br />
	<input type="submit" value="Register" />
</form>
</div>

<?php
render('footer');
?>
