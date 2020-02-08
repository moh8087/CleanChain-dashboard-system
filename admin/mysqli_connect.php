<?php # mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.


// STEP 2. Build Connection
// Secure way to store Connection Infromation
$file = parse_ini_file("../../../mshwark.ini");   // accessing the file with connection infromation

// retrieve data from file
$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);



// Set the database access information as constants:
DEFINE ('DB_USER', $user);
DEFINE ('DB_PASSWORD', $pass);
DEFINE ('DB_HOST', $host);
DEFINE ('DB_NAME', $name);

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
}
mysqli_query($dbc,"set character_set_server='utf8'");
mysqli_query($dbc,"set names 'utf8'");
?>
