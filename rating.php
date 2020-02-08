<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 06.06.16
 * Time: 21:57
 */



// STEP 1. Declare variables to store user information
// array will store all informaiton
if ( empty($_REQUEST["id"]) || empty($_REQUEST["rate"]) ) {

    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    return;

}


// STEP 1.1 Pass POST / GET via html encryp and assign to vars
$id = htmlentities($_REQUEST["id"]);
$rate = htmlentities($_REQUEST["rate"]);





// STEP 2. Build Connection
// Secure way to store Connection Infromation
$file = parse_ini_file("../../mshwark.ini");   // accessing the file with connection infromation

// retrieve data from file
$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

// include MySQLDAO.php for connection and interacting with db
require("secure/access.php");

// running MySQLDAO Class with constructed variables
$access = new access($host, $user, $pass, $name);
$access->connect();   // launch opend connection function



// set rate to be rated

// STEP 4. Rate
$rating = $access->rateRequest($rate,$id);

if (!empty($rating)) {
    $returnArray["message"] = "Successfully rated";
    $returnArray["success"] = true;

  }
  else {
      $returnArray["message"] = "Could not rate request";
      $returnArray["success"] = false;
  }




/* send email to Driver
if (!empty($result["demail"])) {

require ("secure/email.php");

// store all class in $email var
$email = new email();


// refer emailing information
$details = array();
$details["subject"] = "Request is Cancelled";
$details["to"] = $result["demail"];
$details["fromName"] = "مشوارك";
$details["fromEmail"] = "mshwarkk@gmail.com";



$details["body"] =" <!DOCTYPE html>
<html>
<body>

<p>Rider has been cancelled the request</p>
<p>Request number is: " . $result["id"] . "</p>
<p>Rider name: " . $result["rname"] . "</p>
<p>Rider mobile: " . $result["rmobile"] . "</p>

</body>
</html>";


$email->sendEmail($details);
}*/






// STEP 5. Close connection after registration
$access->disconnect();



// STEP 6. JSON data
echo json_encode($returnArray);




?>


