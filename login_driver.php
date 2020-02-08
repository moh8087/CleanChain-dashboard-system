<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 06.06.16
 * Time: 21:57
 */



// STEP 1. Declare variables to store user information
// array will store all informaiton
if ( empty($_REQUEST["mobile"]) || empty($_REQUEST["password"])) {

    $returnArray["status"] = "400";
    $returnArray["message"] = "Missing required information";
    return;

}

// Secure parsing of username and password variables
//$email = htmlentities($_REQUEST["email"]);
$mobile = htmlentities($_REQUEST["mobile"]);
$password = htmlentities($_REQUEST["password"]);


// trim mobile
$mobile = '966' . substr($mobile,1);



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



// STEP 3. Get user
$user = $access->getDriver($mobile);

if (empty($user)) {

    $returnArray["status"] = "403";
    $returnArray["message"] = "User is not found";
    echo json_encode($returnArray);
    return;

}



// STEP 4. Check validity of entered user information and information from database
// 4.1 Get password and salt from database
$secure_password = $user["password"];
$salt = $user["salt"];
//$emailConfirmed = $user["emailConfirmed"]; // to make sure Driver is activited


// 4.2 Check if entered passwords match with password from database
//if ($secure_password == sha1($password . $salt)) {
if ($secure_password == sha1($password)) {

    $returnArray["status"] = "200";
    $returnArray["message"] = "Logged in successfully";
    $returnArray["did"] = $user["did"];
    $returnArray["demail"] = $user["demail"];
    $returnArray["dmobile"] = $user["dmobile"];
    $returnArray["dfullname"] = $user["dfullname"];
    $returnArray["emailConfirmed"] = $user["emailConfirmed"];
    $returnArray["success"] = true;



    echo json_encode($returnArray);
    return;

} else {

    $returnArray["status"] = "403";
    $returnArray["message"] = "Password do not match Or your account is not active";
    echo json_encode($returnArray);
    return;

}


// STEP 5. Close connection after registration
$access->disconnect();



// STEP 6. JSON data
echo json_encode($returnArray);




?>
