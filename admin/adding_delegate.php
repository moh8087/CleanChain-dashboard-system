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
        
        
        // *************************************************************************
        //                     Display all delegates on dropdown list
        //
        // *********************************************************************
        
        
        	echo '<br>';
			echo '	<div id="logo">
                    <h3> Order detials:  ' . $id . '		</h3>
                    </div>';

			echo '<br>';
        
        
        
        	require_once (MYSQL);



	// Display all teacher's exams
	$q = "SELECT did, demail, dmobile, dfullname FROM drivers";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

            
            echo ' <div class="container-fluid">

                <form action="adding_delegate.php" method="post" role="form">

                <div class="panel panel-default">
                <div class="panel-heading">Assign order to:</div>
                <div class="panel-body">
                
                <div class="form-group form-group-lg">
                <select class="form-control" name="price" id="price">';
            


			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r)) {
                

          
                echo'<option value="' .  $row['dmobile'] . '">' .  $row['dfullname'] . '</option>';

             }// end while
            
            
              echo '  </select>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary btn-lg" >Assign</button>
	       <input type="hidden" name="id" value=' . $id . ' />
           </div>
           </div>
            </form>
            </div>
			 <br> ';
            
        

			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			  echo '<div class="alert alert-warning">Hello, there are no delegated to show</div>';
				echo'<div class="panel panel-success">
				<div class="panel-heading">Information:</div>
				<div class="panel-body">Delegate will be shown here</div>
				</div>';

				
		}
        
        
        
        
        
        
        
        

        // *********************************************************************
        //                      Display orders
        //
        // *********************************************************************
        
        
        require_once (MYSQL);

	// Display order detials
	$q = "SELECT * FROM requests WHERE id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

		



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
			
			
			
			// small menu
			echo'
			 <div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">Menu
				</div>    ';
            
            
            
            echo '<div class="table-responsive">
            <table class="table table-bordered">
            
            <tr>
            
            <td><a href="show_order.php?id=' .  $row['id'] . '">Assign to delegate</a></td>
            <td><a href="show_order.php?id=' .  $row['id'] . '">Adding price</a></td>
            <td><a href="print_order.php?id=' .  $row['id'] . '" target="_blank">print invoice</a></td>
            <td><a href="delete_request.php?id=' .  $row['id'] . '">Delete this order</a></td>
            
            
            </tr></table></div>;';
            
			
			
			
			
?>			
			
			
			
			
			
		
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
                        
                        
         // *************************************************************************
        //                      Form submission
        //
        // *********************************************************************
                        

		 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];

							echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
							<li ><a href="cpanel.php">Orders</a></li>
							<li class="active">Assign delegate</li>
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
	$mobile = FALSE;

	// Check for the question:
	if (!empty ($trimmed['price'] ) )
	 {

		$mobile = mysqli_real_escape_string ($dbc, $trimmed['price']);
		$mobile = trim($mobile);
		$mobile = htmlspecialchars($mobile);
	} else {
			echo '<div class="alert alert-danger">Please Enter value</div>';

	}



	if ($mobile) { // If everything's OK...
        
        
        
         // *************************************************************************
        //          Bring delgate data from drivers table
        //          to add into request table
        //
        // **************************************************************************
        
        
        require_once (MYSQL);

	// Display order detials
	$q = "SELECT did, demail, dfullname FROM drivers WHERE dmobile='$mobile'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            
            $did = $row['did'];
            $demail = $row['demail'];
            $dfullname = $row['dfullname'];
            $status = "assigned";
            
			
			
		
			mysqli_free_result ($r); // Free up the resources
			
			
			
			
			
			
			
		}

		else
		{
            $did = "no delagate assigned";
            $demail = "no delagate assigned";
            $dfullname = "no delagate assigned";
		}
        
        
        
        
        
        
        
        
        // *************************************************************************
        //                      // Add delegate data to request
        //
        // *********************************************************************

			
			$q2 = "UPDATE requests SET did='$did' , demail='$demail', dmobile='$mobile' , dname='$dfullname', status='$status' WHERE id='$id'";
        
			$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

                     $last_id = mysqli_insert_id($dbc);

			    echo '<div class="alert alert-success">Total Price is successfully added <a href="show_order.php?id=' .  $id . '">Display order</a>
                Or <a href="adding_delegate.php?id=' .  $id . '">Modify assign to </a></div>';
				echo '<br> <br>';
                
                 // ****************************************************
                 //        Sending SMS to Delegate
                 // ****************************************************
                
                
                    require_once (MYSQL);

	// Display order detials
	$q = "SELECT * FROM requests WHERE id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

		



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		
                    $order_id  = $row["id"];
                    $customer_name  = $row["rname"];
                    $customer_mobile  = $row["rmobile"];
                    $lat = $row["picklatitude"];
                    $long = $row["picklongitude"];;
                
			
		

			
			mysqli_free_result ($r); // Free up the resources
			
			
			
			
			
			
			
		}

		else
		{
			echo '<div class="alert alert-warning">There is no order to show</div>';

		}
                
                
                
                // ****************************
                // Send SMS here
                // ****************************
                
                    $message = "New Order: " . $order_id . "";
                    $message .= ", Customer name: " . $customer_name . "";
                    $message .= ", Mobile: " . $customer_mobile . "";
                    $message .= " Location: http://www.google.com/maps/place/". $lat .",". $long ."";
                
                
                   $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
                    [
                        'api_key' =>  '0a3150b3',
                        'api_secret' => 'ffb1dc4ce654ad67',
                        'type' => 'unicode',
                        'to' => $mobile,
                        'from' => '966583030313',
                        'text' => $message
                    ]
                   );

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);

                //echo $response;
                
                
                



			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">Cannot add price</div>';
			}
        
        
        



	} // Enf If everything's OK...
    
    else { // If one of the data tests failed.
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
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
