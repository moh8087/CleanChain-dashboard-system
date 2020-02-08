<?php

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'All orders';
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

	if (!isset($_GET['page']))
	{
		$page = 1;
	}
	else
	{
		$page = (int) $_GET['page'];
	}

	// define the user
	$u = $_SESSION['user_id'];


	$questions_at_page = 20;

	$q = "SELECT id, email, rid, rname, rmobile,pickaddress, picklatitude, picklongitude, did, dname, dmobile, totalcharge, status, created_at FROM requests";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	$questions_count = mysqli_num_rows($r);
	@mysqli_free_result($r);

	$pages_count = (int)ceil ($questions_count / $questions_at_page );

	if (($page > $pages_count) || ($page <=0))
	{
		mysqli_close($dbc);
		die('لا يوجد المزيد من السجلات');
	}

	$start = ($page - 1 ) * $questions_at_page;
	$end = $questions_at_page;

	if ($questions_count !=0)
	{
		$q = "SELECT id, email, rid, rname, rmobile,pickaddress, picklatitude, picklongitude, did, dname, dmobile, totalcharge, status, created_at FROM requests ORDER BY id DESC LIMIT $start,$end";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0 )
		{
				echo '<br>';
			echo'<div id="logo">
            <h3>All Orders: </h3>
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

			

			//$new_date = date('d/m/Y', strtotime($row['created']));
			echo '<tr>

			<td>' . $row['id'] . '</td>
			<td>' . $row['created_at'] . '</td>
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
			else if ($row['status'] == "later")
			{
				$status = "later";
				echo '<div style="color:orange"> ' . $status . '</div> ';
			}
			else
			{
				
				echo '<font color=blue>open</font> ';
				
			}
			
			
			
			echo'</td>
			<td>  <div style="color:green"> ' . $row['totalcharge'] . '</div>	</td>
			
			
			<td><a href="show_order.php?id=' .  $row['id'] . '"><img src="images/edit2.png" alt="" /></a></td>
			<td><a href="delete_request.php?id=' . $row['id'] . '"><img src="images/delete.png" alt="" /></a></td>
			</tr>';

            }

			echo '</table></div>'; // Close the table



		}

		else
		{
			echo '<p class="error">No records</p>';
		}


mysqli_free_result ($r); // Free up the resources
		}


$next = $page + 1;
$prev = $page -1;

if ($next <= $pages_count)
echo '<a href ="orders.php?page=' . $next . '"> Next </a>';

	 if (($next <= $pages_count) && ($prev > 0) )
	   echo ' - ';

if ($prev > 0 )
	echo '<a href ="orders.php?page=' . $prev . '"> Previous </a>';

mysqli_close($dbc);







?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
