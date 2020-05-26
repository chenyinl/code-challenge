<?php
/**
 * A simple REST API
 */
require_once ('../src/Rest.php');
require_once ('../src/Activity.php');
require_once ('../config/parameters.php');

// Not allowing corss domain Ajax
// header('Access-Control-Allow-Origin: http://localhost', false);

$method = $_SERVER['REQUEST_METHOD'];

// Not allowing OPTIONS since not allowing CROS
if ($method == 'OPTIONS') {
	//header("Access-Control-Allow-Methods: POST, OPTIONS");         
	exit(0);
}

// Only allow POST
if($method != 'POST'){
	exit(0);
}

// get username and password
$username = $_POST['uname'];
$password = $_POST['psw'];

// get database connection
global $db_username, $db_password, $db_server, $db_name;
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
  error_log("Connection failed: " . $conn->connect_error);
  exit();
} 

// Login: check the password
$rest = new Rest();
$result = $rest->login($username, $password, $conn);

// Log the activities
$activity = new Activity();
$activity -> log($username, $result['result'], $result['internal_message'], $conn);

// close database connection
$conn->close();

// Remove internal message, only display public message
unset ($result['internal_message']);
header("Content-Type: application/json");
echo json_encode($result);
exit();
