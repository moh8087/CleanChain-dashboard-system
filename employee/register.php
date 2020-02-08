<?php
require_once ('includes/config.inc.php');
$page_title = 'New Registration';
include ('includes/header_login.html');

if (isset($_POST['submitted'])) { // Handle the form.

	require_once (MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$fn = $ln = $e = $p = $phone = FALSE;

	// Check for a first name:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['fullname'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['fullname']);
	} else {
		echo '<div class="alert alert-danger">Enter your name<div>';
	}


	// Check for an email address:
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<div class="alert alert-danger">Enter your email </div>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{6,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		} else {
			echo '<div class="alert alert-danger">Password does not match</div>';
		}
	} else {
		echo '<div class="alert alert-danger">Enter a correct password not less than 6 character or numbers</div>';
	}

	// Check for the phone:
	if (!empty ($trimmed['phone'] ) ) // becacuse phone is optional.
	 {
		 if (preg_match ('/^[0-9]{1,}$/', $trimmed['phone'])) {
		$phone = mysqli_real_escape_string ($dbc, $trimmed['phone']);
	}
	else {
		echo '<div class="alert alert-danger">Mobile should be number</div>';

	}

	 }

	else
	{
		$phone = TRUE;

	}



	if ($fn && $e && $p && $phone) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM admins WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 0) { // Available.

			/*if you want to force users to activation
			// Create the activation code:
			$a = md5(uniqid(rand(), true));
			$q = "INSERT INTO users (email, pass, fullname, active, registration_date) VALUES ('$e', SHA1('$p'), '$fn', '$a', NOW() )";

			*/


			// Add the user to the database:
			$q = "INSERT INTO drivers (demail, password, dfullname, date, dmobile) VALUES ('$e', SHA1('$p'), '$fn', NOW(), '$phone')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.


				// Finish the page:
				echo '<div id="banner-wrapper">
									<div id="banner" class="box container">
									<center><div class="alert alert-success">Registration is Done</div>';
				echo '<div id="logo">
				<h3>Login </h3>
				 </div></center>';

				// put login page
				echo'	<div class="container-fluid">
				   <form action="login.php" method="post" role="form">
				    <div class="form-group">
				      <label for="email">Email:</label>
				      <input type="email" name="email" class="form-control" id="email" placeholder="">
				    </div>
				    <div class="form-group">
				      <label for="pwd">Password:</label>
				      <input type="password" name="pass" class="form-control" id="pwd" placeholder="">
				    </div>
				    <button type="submit" class="btn btn-primary btn-lg">Login</button>
					<input type="hidden" name="submitted" value="TRUE" />
					<a href="forgot_password.php">    Forgot password?</a>
				  </form>
				</div>
				</div>
				</div>
				</div>';


				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.



				/* to send activation code to the user's email use this code:
				// Send the email:
				$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');

				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				*/




			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">Sorry, we cannot go through please try again</div>';
				//echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}

		} else { // The email address is not available.
			echo '<div class="alert alert-danger">Email is already taken</div>';
				}

	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">Re-Type your password</div>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>

<div id="banner-wrapper">
					<div id="banner" class="box container">

<div id="logo">
<h3>Registraion Employee   </h3>
 </div>



<div class="container-fluid">
   <form form action="register.php" method="post" role="form">
    <div class="form-group">
      <label for="text">Name:</label>
      <input type="text" name="fullname" class="form-control" id="usr" placeholder="" value="<?php if (isset($trimmed['fullname'])) echo $trimmed['fullname']; ?>">
    </div>
	<div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>">
    </div>
    <div class="form-group">
      <label for="pwd">Enter your password":</label>
      <input type="password" name="password1" class="form-control" id="pwd" placeholder="">
    </div>
	<div class="form-group">
      <label for="pwd">Re-type your password</label>
      <input type="password" name="password2" class="form-control" id="pwd" placeholder="">
    </div>

	<div class="form-group">
      <label for="text">Mobile (Optional)</label>
      <input type="text"  name="phone" class="form-control" value="<?php if (isset($trimmed['phone'])) echo $trimmed['phone']; ?>" />
    </div>


    <button type="submit" class="btn btn-primary btn-lg">Register</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>







<a href="login.php" title="Login"> Do you have an account? Login </a><br />



</div>

</div>

<?php // Include the HTML footer.
include ('includes/footer.html');
?>
