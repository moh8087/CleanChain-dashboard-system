<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Delete order';
include ('includes/header.html');

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

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];
			
			 require_once (MYSQL);
		   
		   // To prevent the other teachter to edit each other 
		$q = "SELECT id FROM requests WHERE (id='$id')";		
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
		
					
					
			echo '<form action="delete_request.php" method="post">';

			echo '<div class="panel panel-danger">
      <div class="panel-heading"> Are you sure to delete this order?</div>
      <div class="panel-body">  
	  <input type="radio" name ="active" value="1"  > Yes
     <input type="radio" name ="active" value="2" checked > No
	 </div>
    </div>
	<br>
    <button type="submit" class="btn btn-danger btn-lg" name="submit">Delete</button>
	<input type="hidden" name="id" value="' . $id . '" />


</form>
';
			
	
				
     
	}
     
	 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];	
	 
         
		 
		 require_once (MYSQL);
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);
	 
	
	
	

	
	if ($trimmed['active'] == 1) { // If the choice is OK for delete test...
		
			
		
			/* Move it to trash table
			$new_q = "INSERT INTO exam_trash select * from exam where exam_id='$id'";
			$new_r = mysqli_query ($dbc, $new_q) or trigger_error("Query: $new_q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			
			if (mysqli_affected_rows($dbc) == 1) {*/
				
				
				
				// delete the exam to the database:
			$q = "DELETE from requests  WHERE id='$id'";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			  
			     echo '<div class="alert alert-success">Order successfully deleted</div>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
				
			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">Cannot delete this order </div>';
			}
			
			 mysqli_free_result ($r); // Free up the resources

			//}
	}
	 
	 
	else { // No valid ID, stop the script.
           echo '<div class="alert alert-danger">Cannot delete this order </div>';
          }
	

            

	}
	
	
	else
	{
		echo '<div class="alert alert-danger">Error in deleting </div>';
	}







			

?>






</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
