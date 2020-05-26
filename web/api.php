<?php
/**
 * A simple REST API
 */
require_once ('../src/Rest.php');
require_once ('../src/Auth.php');
require_once ('../src/Activity.php');
require_once ('../config/parameters.php');


// API process
$rest = new Rest();
$rest -> checkMethod();

// Connect to DB
try{
    $conn = $rest -> getDBConnection();
}catch (Throwable $t){
    error_log($t->getMessage());
    $error = array(
		"result" => "failed",
		"public_message"   => "Server Error"
	);
    $rest->returnJSON($error);
}

// Login: check the password
$username = $_POST['uname'];
$password = $_POST['psw'];
$auth = new Auth();
$result = $auth->login($username, $password, $conn);

// Log the activities
$activity = new Activity();
$activity -> log(
	$username, 
	$result['result'], 
	$result['internal_message'], 
	$conn
);

// close database connection
$conn->close();

// echo out the result
$rest->returnJSON($result);
