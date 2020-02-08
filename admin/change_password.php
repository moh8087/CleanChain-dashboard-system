<?php # Script 16.11 - change_password.php
// This page allows a logged-in user to change their password.

require_once ('includes/config.inc.php');
$page_title = 'Change password';
include ('includes/header_cpanel.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 1))
{

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}


?>

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>Hi';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';



	// Display teacher menu:
	include ('includes/menu.php');






if (isset($_POST['submitted'])) {
	require_once (MYSQL);

	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (preg_match ('/^(\w){4,20}$/', $_POST['password1']) ) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['password1']);
		} else {
			echo '<div class="alert alert-danger">Password does not match</div>';
		}
	} else {
		echo '<div class="alert alert-danger">Enter crroect password more than 6 numbers</div>';
	}

	if ($p) { // If everything's OK.

		// Make the query.
		$q = "UPDATE admins SET pass=SHA1('$p') WHERE user_id={$_SESSION['user_id']} LIMIT 1";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email, if desired.
			echo '<div class="alert alert-success">Change password is already done</div>';
			mysqli_close($dbc); // Close the database connection.
			include ('includes/footer.html'); // Include the HTML footer.
			exit();

		} else { // If it did not run OK.

			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>';

		}

	} else { // Failed the validation test.
		echo '<div class="alert alert-danger">Try again</div>';
	}

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>

<div id="logo">
<h3>Change your password </h3>
 </div>


<div class="container-fluid">
  <form action="change_password.php" method="post" role="form">
      <div class="form-group">
      <label for="pwd">New password</label>
      <input type="password" name="password1" class="form-control" id="pwd" placeholder="">
    </div>
    <div class="form-group">
      <label for="pwd">Re-type new password</label>
      <input type="password" name="password2" class="form-control" id="pwd" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Change</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>





</div>
</div>

<?php
include ('includes/footer.html');
?>
