<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'عرض معلومات راكب';
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

echo '<h1>مرحبا';
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




	// Display all driver's info
	$q = "SELECT * FROM users WHERE id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

		



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
			
			
				echo '<br>';
			echo '	<div id="logo">
                    <h3> عرض معلومات الراكب:  ' . $row['fullname'] . '		</h3>
                    </div>';

			echo '<br>';
			
			
			// small menu
			echo'
			 <div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">إجراءات
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li><a href="driver_bill.php?id=' .  $id . '">كشف حساب</a></li>
				<li><a href="add_bill.php?id=' .  $id . '">إضافة كشف</a></li>
				</ul>
				</div>    ';
			
			
			
			
						
			
			
			// Driver's Photo

			echo '<center>
			<br>
			 <img src="images/photo.png" alt="" />
			 <br>';
			
			
			
			
		
			
			
			// Driver's Info
			echo '<div class="table-responsive">
												 <table class="table table-bordered">
												 <tr><td><b>الاسم:  </b></td><td>' . $row['fullname'] . '</td></tr>
												 <tr><td><b>البريد الإلكتروني:</b></td><td>' . $row['email'] . ' - <a href="change_email.php">تغيير البريد الإلكتروني</a></td></tr>
												 <tr><td><b>رقم الجوال:</b></td><td>' . $row['mobile'] . ' - <a href="change_mobile.php">تعديل رقم الجوال</a></td></tr>
												 <tr><td><b>الرصيد:  </b></td><td>' . $row['balance'] . '</td></tr>';




										echo '</table></div>
										      </center>      '; // Close the table
			
			
			
			 
			


			
			mysqli_free_result ($r); // Free up the resources
			
			
			
						
			
			
			
			
			
			// ***********************************************************************************************
			//                                     احصائية عن السائق
			// ***********************************************************************************************
			
			
			// عدد الطلبات:
	
	 // sql statement
        $sql = "SELECT id FROM requests  WHERE rid='$id'" ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsNumber = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		
		
		// عدد الطلبات الملغاة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and status='cancelled'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsCancelled = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// عدد الطلبات المكتملة:
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and status='completed'    " ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsCompleted = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// عدد الطلبات الغير مكتملة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and status='open'" ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsNotCompleted = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
			
			
			// عدد الطلبات اللاحقة
	
	 // sql statement
       $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and status='later'    " ;
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
		$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and created_at BETWEEN '".$today_start."' AND '".$today_now."' " ;

        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		// $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$tripsToday = mysqli_num_rows($r) ;
		
		mysqli_free_result ($r); // Free up the resources
		
		
		
		
		// 	إجمالي المبالغ المكتسبة
	
	 // sql statement
        $sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id'" ;
        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

        // Fetch and print the records:
		
		 $totalprice = 0 ;

		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { 
		
		$totalprice = $totalprice + $row["totalcharge"];
		
		}
		
		mysqli_free_result ($r); // Free up the resources
		
		
	

    	// إجمالي المبالغ المكتسبة اليوم
	
	    // sql statement
        //$today = date('yyyy-MM-dd HH:mm:ss');
		$today_start = date('Y-m-d 00:00:00');
		$today_now = date('Y-m-d H:i:s');
		

        //$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE created_at='".$today."' " ;
		$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and created_at BETWEEN '".$today_start."' AND '".$today_now."' " ;

        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

       $TodayTotalPrice = 0 ;

		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { 
		
		$TodayTotalPrice = $TodayTotalPrice + $row["totalcharge"];
		
		}
		
		
		mysqli_free_result ($r); // Free up the resources
		
		
		// إجمالي المبالغ المكتسبة هذا الشهر
	
	    // sql statement
        //$today = date('yyyy-MM-dd HH:mm:ss');
		$month_start = date('Y-m-01 00:00:00');
		$month_now = date('Y-m-d H:i:s');
		

        //$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE created_at='".$today."' " ;
		$sql = "SELECT id ,totalcharge, status, created_at FROM requests WHERE rid='$id' and created_at BETWEEN '".$month_start."' AND '".$month_now."' " ;

        // assign result we got from $sql to $result var
        $r =  mysqli_query ($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));

       $MonthTotalPrice = 0 ;

		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { 
		
		$MonthTotalPrice = $MonthTotalPrice + $row["totalcharge"];
		
		}
		
		
		mysqli_free_result ($r); // Free up the resources
		
		
		
		
		
		


     	
		
		
		
		
		
			echo '<br>';
			echo '	<div id="logo">
                    <h3>احصائيات:  </h3>
                    </div>';

			echo '<br>';

			echo '<center>';



			

	
			
			
			
			
			
			// Row 1
			echo '<div class="table-responsive">
                  <table class="table table-condensed">
			<tr class="success">
			<td><b>عدد الطلبات:</b></td>
			<td><b>عدد الطلبات الملغاة:</b></td>
			<td><b>عدد الطلبات المكتملة:</b></td>
			</tr>';

			echo '<tr>
			
			<td> ' . $tripsNumber . '</td>
			<td>' . $tripsCancelled . '</td>
			<td>' . $tripsCompleted . ' </td>
	
			</tr>';

			//echo '</table></div>'; // Close the table
			
			
			
			
			// Row 2
			echo '<br>
			
			<tr class="danger">
			<td><b>عدد الطلبات الغير مكتملة:</b></td>
			<td><b>عدد الطلبات اللاحقة:</b></td>
			<td><b>عدد طلبات اليوم:</b></td>
			</tr>';

			echo '<tr>
			
			<td> ' . $tripsNotCompleted . '</td>
			<td>' . $tripsCancelled . '</td>
			<td>' . $tripsCompleted . ' </td>
	
			</tr>';

			//echo '</table></div>'; // Close the table
			
			
			
			// Row 3
			echo '<br>
			
			<tr class="info">
			<td><b>إجمالي الدفع: ( بالريال)</b></td>
			<td><b>إجمالي الدفع اليوم ( بالريال)</b></td>
			<td><b>إجمالي الدفع بالشهر (بالريال)</b></td>
			</tr>';

			echo '<tr>
			
			<td> ' . $totalprice . '</td>
			<td>' . $TodayTotalPrice . '</td>
			<td>' . $MonthTotalPrice . ' </td>
	
			</tr>';

			echo '</table></div>'; // Close the table
			
			
			
			
			
			
			
			echo'	
						
			</center>
			';
			
			
			
			
			
			
			
			
			
			
			
			
			
		}

		else
		{
			echo '<div class="alert alert-warning">لا يوجد راكب لعرض بياناته</div>';

		}








	}

		else
		{

			echo '<div class="alert alert-danger">لا يوجد راكب لعرض بياناته</div>';
		}







?>

</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
