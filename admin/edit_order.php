<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Modifing Order';
include ('includes/header_cpanel.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']))
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

echo '<h1>Hi';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

// Display teacher menu:

	include ('includes/menu.php');


	require_once (MYSQL);

	// define the user
	$user = $_SESSION['user_id'];


	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From student.php
           $id = $_GET['id'];


		   require_once (MYSQL);




	// Display order detials
	$q = "SELECT * FROM requests WHERE id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

		



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
			
			
				echo '<br>';
			echo '	<div id="logo">
                    <h3> Order detials:  ' . $id . '		</h3>
                    </div>';

			echo '<br>';
			
			
			// small menu
			echo'
			 <div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">Menu
				</div>    ';
            
            
            
            echo '<div class="table-responsive">
            <table class="table table-bordered">
            
            <tr>
            
            <td><a href="adding_delegate.php?id=' .  $row['id'] . '">Assign to delegate</a></td>
            <td><a href="show_order.php?id=' .  $row['id'] . '">Adding price</a></td>
            <td><a href="print_order.php?id=' .  $row['id'] . '" target="_blank">print invoice</a></td>
            <td><a href="delete_request.php?id=' .  $row['id'] . '">Delete this order</a></td>
            
            
            </tr></table></div>';
            
			
			
			
			
?>			
			
			<center>
			<br>
			  <div class="container-fluid">

  <form action="edit_order.php" method="post" role="form">

  <div class="panel panel-default">
      <div class="panel-heading">Modify Order Detials:</div>
      <div class="panel-body">
	  <div class="form-group">
      <input type="text" name="price" class="form-control" id="text" placeholder= ""
             value="<?php echo $row['notes']; ?>">
    </div></div>
    </div>

	<button type="submit" name="submit" class="btn btn-primary btn-lg" >Modify</button>
	<input type="hidden" name="id" value=<?php echo $id // to save the id which is exam id ?> />

</form>
</div>
			 <br>';
			
			
			
			
		
<?php			
			
			// Driver's Info
			echo '<div class="table-responsive">
        
                  <table class="table table-bordered">
                  <tr><td><b>Order ID: </b></td><td>' . $id . '</td></tr>
                   <tr><td><b>Created at: </b></td><td>' . $row['created_at'] . '</td></tr>
                   <tr><td><b>Order detials: </b></td><td>' . $row['notes'] . '</td></tr>
                    <tr><td><b>Customer name: </b></td><td>' . $row['rname'] . '</td></tr>
                    <tr><td><b>Mobile: </b></td><td>' . $row['rmobile']  . '</td></tr>
                    <tr><td><b>Email:</b></td><td>' . $row['email'] . '</td></tr>
                    <tr><td><b>Address: </b></td><td>' . $row['pickaddress'] . '</td></tr>
                    <tr><td><b>Location on map: </b></td><td><a href="http://www.google.com/maps/place/'. $row["picklatitude"] .','. $row["picklongitude"] .'"><img src="images/link.png" alt="" /></a></td></tr>
                    <tr><td><b>Assign to : </b></td><td><a href="show_driver.php?id=' .  $row['did'] . '">' .  $row['dname'] . '</a></td></tr>
                    <tr><td><b>Delegate Mobile: </b></td><td>' . $row['dmobile'] . '</td></tr>
                    <tr><td><b>Orders status:</b></td><td>' . $row['status'] . '</td></tr>
                    <tr><td><b>Total Price:  </b></td><td>' . $row['totalcharge'] . '</td></tr>
                    
                    </table></div>
										      </center>      '; // Close the table
			
			
			
			 
			


			
			mysqli_free_result ($r); // Free up the resources
			
			
			
			
			
			
			
		}

		else
		{
			echo '<div class="alert alert-warning">There is no order to show</div>';

		}








	}

		 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];

							echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
							<li ><a href="create_test.php">Orders</a></li>
							<li class="active">Adding price</li>
							<li ><a href="show_order.php?id=' .  $id . '">Display order</a></li>
						</ol>
						<br>';

												echo'<div id="logo">
						            <h3>Adding price: </h3>
						            </div>';


	require_once (MYSQL);



	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$price = FALSE;

	// Check for the question:
	if (!empty ($trimmed['price'] ) )
	 {

		$price = mysqli_real_escape_string ($dbc, $trimmed['price']);
		$price = trim($price);
		$price = htmlspecialchars($price);
	} else {
			echo '<div class="alert alert-danger">Please Enter value</div>';

	}



	if ($price) { // If everything's OK...
        
        

			// Add the question to the database:
			$q = "UPDATE requests SET notes='$price' WHERE id='$id'";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

                     $last_id = mysqli_insert_id($dbc);

			    echo '<div class="alert alert-success">Detials is successfully modified <a href="show_order.php?id=' .  $id . '">Display order</a>
                Or <a href="adding_price.php?id=' .  $id . '">Modify Detials agian</a></div>';
				echo '<br> <br>';



			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">Cannot modify order, There is no change</div>';
			}



	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">Please enter price correctly</div>';
	}

	mysqli_close($dbc);

// End of the main Submit conditional.

             }
	else { // No valid ID, stop the script.
           echo '<div class="alert alert-danger">Enter date correctly</div>';
          }
                        
                        
                        







?>
                        

                        
                        
                        
                        

</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
