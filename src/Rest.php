<?php
/**
 * A simple REST API class
 */
class Rest
{
	/**
	 * Check if the http method is allowed
	 */
    public function checkMethod (): void
    {
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
    }

    /**
     * Connect to the database
     *
     * Use Prepare statment to prevent SQL injection
     *
     * @param string $username Look up the DB by user name
     */
    public function getDBConnection(): mysqli
    {
        // get database connection
        global $db_username, $db_password, $db_server, $db_name;
        $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: ".$conn->connect_error);
        }
        return $conn;
    }

    /**
     * Math the password hash
     *
     * @param string $password The password given by the user
     * @param array $passwordObject The data from database
     */
    public function returnJSON(array $result ): void
    {
        // Remove internal message, only display public message
        unset ($result['internal_message']);
        
        header("Content-Type: application/json");
        echo json_encode($result);
        exit();
    }
}
