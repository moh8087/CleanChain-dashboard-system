<?php
/**
 * Created by MUhammad.
 * User: macbookpro
 * Date: 06.06.16
 * Time: 21:57
 */



// STEP 1. Declare variables to store user information
// array will store all informaiton
if ( empty($_REQUEST["id"]) || empty($_REQUEST["price"]) || !(is_numeric($_REQUEST["price"]))  ) {

    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    $returnArray["success"] = false;
    return;

}


// STEP 1.1 Pass POST / GET via html encryp and assign to vars
$id = htmlentities($_REQUEST["id"]);
$price = htmlentities($_REQUEST["price"]);





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


// Step 3. Bring both Driver and Rider information to send them email



$result = $access->getRequestInfo($id);

if (!empty($result)) {


  $returnArray["id"] = $result["id"];
  $returnArray["email"] = $result["email"];
  $returnArray["rid"] = $result["rid"];
  $returnArray["rname"] = $result["rname"];
  $returnArray["rmobile"] = $result["rmobile"];
  $returnArray["did"] = $result["did"];
  $returnArray["dname"] = $result["dname"];
  $returnArray["demail"] = $result["demail"];
  $returnArray["dmobile"] = $result["dmobile"];
  $returnArray["dphoto"] = $result["dphoto"];
  $returnArray["carmodel"] = $result["carmodel"];
  $returnArray["dlat"] = $result["dlat"];
  $returnArray["dlog"] = $result["dlog"];


  // set status to be Cancelled

  $status = "completed";


// STEP 4. Delete request according to id
$cancel = $access->savePrice($price, $status, $id);

if (!empty($cancel)) {
    $returnArray["message"] = "Total Charge successfully addee";
    $returnArray["success"] = true;

  }
  else {
      $returnArray["message"] = "Could not add price";
      $returnArray["success"] = false;
  }


}
else {

  $returnArray["message"] = "There is no request with this is number";
  $returnArray["success"] = false;


}



// send email to Driver
if (!empty($result["email"])) {

require ("secure/email.php");

// store all class in $email var
$email = new email();


// refer emailing information
$details = array();
$details["subject"] = "Complete Trip";
$details["to"] = $result["email"];
$details["fromName"] = "مشوارك";
$details["fromEmail"] = "mshwarkk@gmail.com";



$details["body"] =" <!DOCTYPE html>
<html>
<body>

<p>Your Trip has been successfully done</p>
<p>Request number is: " . $result["id"] . "</p>
<p>Total Price is :   " . $price . " </p>
<p>Thank you for using Mshwark</p>
<p>See you soon!</p>


</body>
</html>";


$email->sendEmail($details);
}

echo json_encode($returnArray);



// send SMS to Rider
$message = "Your Trip has been successfully done. ";
$message = "Total Price is :   " . $price . "";
$message .= ", Thank you, see you soon.";

$access->sendSMS($result["rmobile"], $message);






// STEP 5. Close connection after registration
$access->disconnect();



// STEP 6. JSON data




?>
