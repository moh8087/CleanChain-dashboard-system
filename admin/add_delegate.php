<?php

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Add Delgate';
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

<div class="container-fluid">

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>Hi';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

	// Display teacher menu:
	include ('includes/menu.php');

require_once (MYSQL);
                        
                        
                        

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


	// Check for the phone:
	
        // Check for an email address:
    if (!empty ($trimmed['email'] ) ) // becacuse phone is optional.
	 {
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<div class="alert alert-danger">Enter your email </div>';
	}
    }
    else
    {
        $e = "1";
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
             
        // trim mobile
        $phone = '966' . substr($phone,1);
	}
	else {
		echo '<div class="alert alert-danger">Mobile should be number</div>';

	}

	 }

	else
	{
		$e = TRUE;

	}



	if ($fn && $phone && $p && $e) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT did FROM drivers WHERE dmobile='$phone'";
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
									<center><div class="alert alert-success">Employee has successfully added</div>';
                
                exit(); // Quit the script.
                echo'</div>';
                include ('includes/footer.html');


			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">Sorry cannot add employee</div>';
				//echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}

		} else { // The email address is not available.
			echo '<div class="alert alert-danger">Mobile is already taken</div>';
				}

	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">Please Enter all data in feilds</div>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>



<div id="logo">
<h3>Adding a delegate:  </h3>
 </div>



<div class="container-fluid">
   <form form action="add_delegate.php" method="post" role="form">
    <div class="form-group">
      <label for="text">Name:</label>
      <input type="text" name="fullname" class="form-control" id="usr" placeholder="" value="<?php if (isset($trimmed['fullname'])) echo $trimmed['fullname']; ?>">
    </div>
       <div class="form-group">
      <label for="text">Mobile </label>
      <input type="text"  name="phone" class="form-control" value="<?php if (isset($trimmed['phone'])) echo $trimmed['phone']; ?>" />
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
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>">
    </div>


    <button type="submit" class="btn btn-primary btn-lg">Add</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>





</div>


<?php // Include the HTML footer.
include ('includes/footer.html');
?>
