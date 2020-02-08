<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Order Detials';
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
            
            <td><a href="adding_delegate.php?id=' .  $row['id'] . '">Assign to delegate  <img src="images/assign.png" alt="" /></a></td>
            <td><a href="adding_price.php?id=' .  $row['id'] . '">Adding price  <img src="images/plus.png" alt="" /></a></td>
<td><a href="delete_request.php?id=' .  $row['id'] . '">Delete this order  <img src="images/delete3.png" alt="" /></a></td>
<td><a href="edit_order.php?id=' .  $row['id'] . '" target="_blank">Edit detials  <img src="images/search.png" alt="" /></a></td>
<td><a href="print_order.php?id=' .  $row['id'] . '" target="_blank">print invoice  <img src="images/printer.png" alt="" /></a></td>
            
            
                    
                    
            
            
            
            </tr></table></div>';
            

			
			
			// Driver's Info
			echo '<div class="table-responsive">
        
                  <table class="table table-bordered">
                  <tr><td><b>Order ID: </b></td><td>' . $id . '</td></tr>
                   <tr><td><b>Created at: </b></td><td>' . $row['created_at'] . '</td></tr>
                   <tr><td><b>Order detials: </b></td><td>' . $row['notes'] . '   <a href="edit_order.php?id=' .  $row['id'] . '" target="_blank">  Edit detials </a> </td></tr>
                    <tr><td><b>Customer name: </b></td><td>' . $row['rname'] . '</td></tr>
                    <tr><td><b>Mobile: </b></td><td>' . $row['rmobile']  . '</td></tr>
                    <tr><td><b>Email:</b></td><td>' . $row['email'] . '</td></tr>
                    <tr><td><b>Address: </b></td><td>' . $row['pickaddress'] . '</td></tr>
                    <tr><td><b>Location on map: </b></td><td><a href="http://www.google.com/maps/place/'. $row["picklatitude"] .','. $row["picklongitude"] .'"><img src="images/link.png" alt="" /></a></td></tr>
                    <tr><td><b>Assign to : </b></td><td>' .  $row['dname'] . '</td></tr>
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

		else
		{

			echo '<div class="alert alert-danger">There is no order to show</div>';
		}







?>

</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
