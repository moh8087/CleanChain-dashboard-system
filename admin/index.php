<?php # Script index.php
// This is the main page for the site.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'لوحة تحكم مشوارك!';
include ('includes/header.html');

?>

<?php
//Welcome the user (by name if they are logged in):
//echo '<h1>مرحبا';
if (isset($_SESSION['fullname'])) {
//	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

			if ($_SESSION['user_level'] == 1)
				{
					$url = BASE_URL . 'cpanel.php'; // Define the URL:
					ob_end_clean(); // Delete the buffer.
					header("Location: $url");
					exit(); // Quit the script.
					}

			elseif ($_SESSION['user_level'] == 2)
			    {
					$url = BASE_URL . 'student.php'; // Define the URL:
					ob_end_clean(); // Delete the buffer.
					header("Location: $url");
					exit(); // Quit the script.

					}
			else {
					echo '<center><div class="alert alert-danger">الحساب غير مفعل <a href="logout.php">تسجيل الخروج</a></div></center>';
					}

}

else {

					$url = BASE_URL . 'login.php'; // Define the URL:
					ob_end_clean(); // Delete the buffer.
					header("Location: $url");
					exit(); // Quit the script.


}

?>


<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
