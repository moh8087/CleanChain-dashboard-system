<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'My profile';
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
echo '<h1>Hello';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

	// Display teacher menu:
	include ('includes/menu.php');



	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];


	// Display all teacher's exams
	$q = "SELECT user_id, fullname, email, registration_date, phone  FROM admins WHERE user_id='$u'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

			echo '<br>';
			echo '	<div id="logo">
                    <h3> My personal info:  </h3>
                    </div>';

			echo '<br>';

			echo '<center>';



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);


			echo '

			<br>
			 <img class="img-responsive" src="images/photo.png" alt=""> 
			 <br>
			 <b>Name:</b>
			 <br>
			 ' . $row['fullname'] . '
			 <br>
			<b>Email:</b>
			<br>
			' . $row['email'] . ' 
			<br>
			<a href="change_email.php">change email</a>
			<br>
			<b>Password:</b>
			<br>
			<a href="change_password.php">change password</a>
			<br>
			<b>Mobile Number:</b>
			<br>';
			
			if (empty ($row['phone'] ) )
			{
				echo '<a href="change_phone.php">Add a mobile</a>';
			}
			else{
				echo '' . $row['phone'] . ' ';
				
			}
			
			echo '<br>
			<a href="change_phone.php">Edit mobile</a>
			<br>
			</center>
			';

			
			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			echo '<div class="alert alert-danger">There is no data</div>';
		}




?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
