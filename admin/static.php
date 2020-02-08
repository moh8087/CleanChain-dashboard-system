<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Statistic';
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


	// عدد الطلبات:
	
	 // sql statement
        $sql = "SELECT id FROM requests " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsNumber = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		
		
		// عدد الطلبات الملغاة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE status='cancelled'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsCancelled = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// عدد الطلبات المكتملة:
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE status='completed'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsCompleted = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// عدد الطلبات الغير مكتملة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE status='assigned'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsNotCompleted = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
			
			
			// عدد الطلبات اللاحقة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE status='received'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsLater = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// عدد الطلبات المكتملة اليوم:
	
	    // sql statement
        //$today = date('yyyy-MM-dd HH:mm:ss');
		$today_start = date('Y-m-d 00:00:00');
		$today_now = date('Y-m-d H:i:s');
		

        //$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE created_at='".$today."' " ;
		$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE created_at BETWEEN '".$today_start."' AND '".$today_now."' " ;

        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsToday = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		
		
		
		


     	
		
		
		
		
		
			echo '<br>';
			echo '	<div id="logo">
                    <h3>Statistic:  </h3>
                    </div>';

			echo '<br>';

			echo '<center>';



			


			echo '

			<br>
			 <img class="img-responsive" src="images/static.png" alt=""> 
			 <br>
			 <b>Total Orders:</b>
			 <br>
			 ' . $tripsNumber . '
			 <br>
			<b>Total Cancelled Orders:</b>
			<br>
			' . $tripsCancelled . ' 
			<br>
			
			<b>Total Completed Orders:</b>
			<br>
			' . $tripsCompleted . ' 
			<br>
			
			<b>Total Assigned Orders:</b>
			<br>
			' . $tripsNotCompleted . ' 
			<br>
			
			<b>Total Received Orders</b>
			<br>
			' . $tripsLater . ' 
			<br>
			
			<b>Today Total Orders:</b>
			<br>
			' . $tripsToday . ' 
			
						
			</center>
			';

			
		




?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
