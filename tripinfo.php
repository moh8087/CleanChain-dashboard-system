<?php



// STEP 1. Declare variables to store user information
// array will store all informaiton
if ( empty($_REQUEST["id"]) ) {

    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    return;

}


// STEP 1.1 Pass POST / GET via html encryp and assign to vars
$id = htmlentities($_REQUEST["id"]);



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



$result = $access->tripInfo($id);

if (!empty($result)) {


  $returnArray["status"] = "200";
  $returnArray["message"] = "Driver is in the way";
  $returnArray["id"] = $result["id"];
  $returnArray["email"] = $result["email"];
  $returnArray["rid"] = $result["rid"];
  $returnArray["rname"] = $result["rname"];
  $returnArray["rmobile"] = $result["rmobile"];
  $returnArray["did"] = $result["did"];
  $returnArray["dname"] = $result["dname"];
  $returnArray["dmobile"] = $result["dmobile"];
  $returnArray["dphoto"] = $result["dphoto"];
  $returnArray["carmodel"] = $result["carmodel"];
  $returnArray["picklatitude"] = $result["picklatitude"];
  $returnArray["picklongitude"] = $result["picklongitude"];
  $returnArray["dlat"] = $result["dlat"];
  $returnArray["dlog"] = $result["dlog"];
  $returnArray["success"] = true;


  // STEP 4. Emailing Rider to notify him that his request has been accepted



  // include email.php
  require ("secure/email.php");

  // store all class in $email var
  $email = new email();


  // refer emailing information
  $details = array();
  $details["subject"] = "Order has been received";
  $details["to"] = $result["email"];
  $details["fromName"] = "CleanChain";
  $details["fromEmail"] = "washingchain@gmail.com";



/*  $details["body"] =" <!DOCTYPE html>
  <html>
  <body>

<p>Driver is in the way, Your request has been accepted</p>
<p>Your Request number is: " . $result["id"] . "</p>
<p>Driver name: " . $result["dname"] . "</p>
<p>Driver mobile: " . $result["dmobile"] . "</p>
<p>Driver Car Model: " . $result["carmodel"] . "</p>
</body>
</html>";*/


$details["body"] = '<html><body>';
$details["body"] .= 'Order has been received, we will contact you shortly';
$details["body"] .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$details["body"] .= "<tr style='background: #eee;'><td><strong>Your Order number is:</strong> </td><td>" . $result["id"] . "</td></tr>";
$details["body"] .= "</table>";
$details["body"] .= "</body></html>";




  $email->sendEmail($details);




  echo json_encode($returnArray);
    
// Number of manger
    $MangerMobile = "966508102094";
    
    
  // send SMS to Driver
  $message2 = "طلب جديد ";
  $message2 .= "New Request: " . $result["id"] . "";
  $message2 .= ", Customer name: " . $result["rname"] . "";
  $message2 .= ", Mobile: " . $result["rmobile"] . "";
  $message2 .= " Location: http://www.google.com/maps/place/". $result["picklatitude"] .",". $result["picklongitude"] ."";

  $access->sendSMS($MangerMobile, $message2);
    
    

  // send SMS to Rider
  $message = "Order has been received. ";
  $message .= " Order number: " . $result["id"] . " ، ";
  $message .= " Thank you. We will contact you shortly ";


  $access->sendSMS($result["rmobile"], $message);
    
    
    /* send SMS to Rider
  $message =" نشكر لك طلبك ، ونعتذر عن خدمتك مؤقتاً لأننا في مرحلة التجريب  ، نراكم قريباً  ";

  $access->sendSMS($result["rmobile"], $message);*/


 


  return;

} else {

  $returnArray["status"] = "403";
  $returnArray["message"] = "still waiting to look for a driver";
  echo json_encode($returnArray);
  return;

}










// STEP 5. Close connection after registration
$access->disconnect();



// STEP 6. JSON data
echo json_encode($returnArray);




?>
