<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 09.06.16
 * Time: 22:15
 */



// STEP 1. Declare parms of user inf
// if GET or POST are empty
if ( empty($_REQUEST["did"]) || empty ($_REQUEST["droplatitude"]) || empty($_REQUEST["droplongitude"])) {
    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    echo json_encode($returnArray);
    return;
}

// Securing information and storing variables
$did = htmlentities($_REQUEST["did"]);
$dlat= htmlentities($_REQUEST["droplatitude"]);
$dlog = htmlentities($_REQUEST["droplongitude"]);






// STEP 2. Build connection
// Secure way to build conn
$file = parse_ini_file("../../mshwark.ini");

// store in php var inf from ini var
$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

// include access.php to call func from access.php file
require ("secure/access_driver.php");
$access = new access($host, $user, $pass, $name);
$access->connect();


// Step 3. Make sure email is not taken
//$sure = $access->getUser($email);

//if(!$sure["id"]) { // if there is no user

  // STEP 4. Insert user information

$result = $access->addDropAddress($dlat, $dlog, $did);

// successfully registered
if ($result) {

    // get current registered user information and store in $user
    $user = $access->getTripDropAddress($did);

    // declare information to feedback to user of App as json
    $returnArray["status"] = "200";
    $returnArray["message"] = "Update successfully";
    $returnArray["id"] = $user["id"];
    $returnArray["droplatitude"] = $user["droplatitude"];
    $returnArray["droplongitude"] = $user["droplongitude"];
    $returnArray["success"] = true;



} else {
    $returnArray["status"] = "400";
    $returnArray["message"] = "Could not register with provided infomraiton";
}




// STEP 5. Close connection
$access->disconnect();


// STEP 6. Json data
echo json_encode($returnArray);



?>
