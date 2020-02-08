<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Control Panel';
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

	// define the user
	$u = $_SESSION['user_id'];


	// Display all teacher's exams
	$q = "SELECT id, email, rid, rname, rmobile,pickaddress, picklatitude, picklongitude, did, dname, dmobile, totalcharge, status, created_at FROM requests ORDER BY id DESC LIMIT 10";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{


				echo '<br>';
				echo'<div id="logo">
            <h3>Orders:  </h3>
            </div>';

			echo '<br>';

			echo '<div class="table-responsive">
                  <table class="table table-condensed">
			<tr class="active">
			<td><b>Order ID</b></td>
			<td><b>Date</b></td>
			<td><b>Customer</b></td>
			<td><b>Assign to</b></td>
			<td><b>Address</b></td>
			<td><b>Location</b></td>
			
			<td><b>Order starus</b></td>
			<td><b>Total Price</b></td>
			
			
			<td><b>Display</b></td>
			<td><b>Delete</b></td>

			</tr>';


			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                
            $new_date = date('d/m/Y', strtotime($row['created_at']));

			

			//$new_date = date('d/m/Y', strtotime($row['created_at']));
			echo '<tr>
            
            <td><a href="show_order.php?id=' .  $row['id'] . '">' .  $row['id'] . '</a></td>
			<td>' . $new_date . '</td>
			<td><a href="show_rider.php?id=' .  $row['rid'] . '">' .  $row['rname'] . '</a></td>
			<td><a href="show_driver.php?id=' .  $row['did'] . '">' .  $row['dname'] . '</a></td>
			<td>' . $row['pickaddress'] . '</td>
			<td><a href="http://www.google.com/maps/place/'. $row["picklatitude"] .','. $row["picklongitude"] .'"><img src="images/link.png" alt="" /></a></td>
			
			
			<td>';
			
			
				if ($row['status'] == "open")
			{
				$status = "open";
				echo '<font color=blue>open</font> ';
			}
			else if ($row['status'] == "cancelled")
			{
				$status = "cancelled";
				echo '<div style="color:red"> ' . $status . '</div>';
				
			}
			else if ($row['status'] == "completed")
			{
				$status = "completed";
				echo '<div style="color:green"> ' . $status . '</div> ';
			}
			else if ($row['status'] == "assigned")
			{
				$status = "assigned";
				echo '<div style="color:orange"> ' . $status . '</div> ';
			}
                else if ($row['status'] == "received")
			{
				$status = "received";
				echo '<div style="color:orange"> ' . $status . '</div> ';
			}
			else
			{
				
				echo '<font color=blue>' . $row['status']. '</font> ';
				
			}
			
			
			
			echo'</td>
			<td>  <div style="color:green"> ' . $row['totalcharge'] . '</div>	</td>
			
			
			<td><a href="show_order.php?id=' .  $row['id'] . '"><img src="images/edit2.png" alt="" /></a></td>
			<td><a href="delete_request.php?id=' . $row['id'] . '"><img src="images/delete.png" alt="" /></a></td>
			</tr>';

						}

			echo '</table></div>'; // Close the table
			echo '<a href ="orders.php"> More </a>';
			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			  echo '<div class="alert alert-warning">Hello, there are no orders to show</div>';
				echo'<div class="panel panel-success">
				<div class="panel-heading">Information:</div>
				<div class="panel-body">Order will be shown here</div>
				</div>';

				
		}



?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
