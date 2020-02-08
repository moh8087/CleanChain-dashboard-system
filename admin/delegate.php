<?php

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Delegate';
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
                        
                        
                        	// small menu
			echo'
			 <div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">Menu
				</div>    ';
            
            
            
            echo '<div class="table-responsive">
            <table class="table table-bordered">
            
            <tr>
            
            <td><a href="add_delegate.php">Add employee</a></td>
            
            
            </tr></table></div>';
                        
                        
                        
                        
                        
                        

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

	$q = "SELECT did, demail, dmobile, dfullname, ava,  emailConfirmed, date, status, carmodel, dlat, dlog FROM drivers";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	$questions_count = mysqli_num_rows($r);
	@mysqli_free_result($r);

	$pages_count = (int)ceil ($questions_count / $questions_at_page );

	if (($page > $pages_count) || ($page <=0))
	{
		mysqli_close($dbc);
		die('There are no records');
	}

	$start = ($page - 1 ) * $questions_at_page;
	$end = $questions_at_page;

	if ($questions_count !=0)
	{
		$q = "SELECT did, demail, dmobile, dfullname, ava,  emailConfirmed, date, status, carmodel, dlat, dlog FROM drivers ORDER BY did DESC LIMIT $start,$end";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0 )
		{
				echo '<br>';
			echo'<div id="logo">
            <h3>All employees: </h3>
            </div>';

			echo '<br>';

			echo '<div class="table-responsive">
                  <table class="table table-condensed">
			<tr class="active">
		<td><b>ID</b></td>
			<td><b>employee Name:</b></td>
			<td><b>Mobile</b></td>
			<td><b>Email</b></td>
			<td><b>Registration at</b></td>
			<td><b>Delete</b></td>


			</tr>';

		

			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			

			//$new_date = date('d/m/Y', strtotime($row['created']));
			echo '<tr>

			<td>' . $row['did'] . '</td>
			<td><a href="show_driver.php?id=' .  $row['did'] . '">' .  $row['dfullname'] . '</a></td>
			<td>' . $row['dmobile'] . '</td>
            <td>' . $row['demail'] . '</td>
			<td>' . $row['date'] . '</td>            			
			<td><a href="delete_driver.php?id=' . $row['did'] . '"><img src="images/delete.png" alt="" /></a></td>
			</tr>';

            }

			echo '</table></div>'; // Close the table



		}

		else
		{
			echo '<p class="error">no records</p>';
		}


mysqli_free_result ($r); // Free up the resources
		}


$next = $page + 1;
$prev = $page -1;

if ($next <= $pages_count)
echo '<a href ="drivers.php?page=' . $next . '"> Next </a>';

	 if (($next <= $pages_count) && ($prev > 0) )
	   echo ' - ';

if ($prev > 0 )
	echo '<a href ="drivers.php?page=' . $prev . '"> Previous </a>';

mysqli_close($dbc);







?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
