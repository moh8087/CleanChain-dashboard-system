<?php



// STEP 1. Declare variables to store user information
// array will store all informaiton
if ( empty($_REQUEST["did"]) ) {

    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    return;
    

}


// STEP 1.1 Pass POST / GET via html encryp and assign to vars
// Rider id
$did = htmlentities($_REQUEST["did"]);



// STEP 2. Build Connection
// Secure way to store Connection Infromation
$file = parse_ini_file("../../mshwark.ini");   // accessing the file with connection infromation

// retrieve data from file
$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

// include MySQLDAO.php for connection and interacting with db
require("secure/access_driver.php");

// running MySQLDAO Class with constructed variables
$access = new access($host, $user, $pass, $name);
$access->connect();   // launch opend connection function



  // Get number of successfull trips
$completednumber = $access->getTripsNumber($did);

// STEP 2.3 If posts are found, append them to $returnArray
if (!empty($completednumber)) {
    $returnArray["completednumber"] = $completednumber;
    $returnArray["success"] = true;
}
else
{
  $returnArray["completednumber"] = "0";  
    
}

// Get number of successfull trips
$cancellednumber = $access->getCancelledNumber($did);

// STEP 2.3 If posts are found, append them to $returnArray
if (!empty($cancellednumber)) {
  $returnArray["cancellednumber"] = $cancellednumber;
  $returnArray["success"] = true;
}
else
{
    $returnArray["cancellednumber"] = "0";
}

// Get total Price of successfull trips
$totalprice = $access->getTotalSuccessfull($did);

// STEP 2.3 If posts are found, append them to $returnArray
if (!empty($totalprice)) {
  $returnArray["totalprice"] = $totalprice;
}

// Get total Price of successfull trips for Today
$totalpricetoday = $access->getTotalSuccessfullToday($did);

// STEP 2.3 If posts are found, append them to $returnArray
if (!empty($totalpricetoday)) {
  $returnArray["totalpricetoday"] = $totalpricetoday;
}












// STEP 5. Close connection after registration
$access->disconnect();



// STEP 6. JSON data
echo json_encode($returnArray);




?>
