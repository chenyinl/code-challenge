<?php
/**
 * A simple class for user activity
 */
Class Activity
{
	/**
	 * Save user's login activities
	 * 
	 * @param string $username The username given by user
	 * @param string $success  The login in result
	 * @param string $notes    Comments for activities
	 */
    public function log(string $username, string $success, string $notes): void
    {
		$this->client_ip   = (!empty($_SERVER['HTTP_CLIENT_IP']))? $_SERVER['HTTP_CLIENT_IP']:"";
		$this->proxy_ip    = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))? $_SERVER['HTTP_X_FORWARDED_FOR']:"";
		$this->remote_addr = (!empty($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR']: "";
		$this->user_agent  = (!empty($_SERVER['HTTP_USER_AGENT']))? $_SERVER['HTTP_USER_AGENT']: "";
		$this->success     = $success;
		$this->notes       = $notes;
		$this->username    = $username;
		$this->composeSQL();
		$this->saveToDB();
    }

    /**
     * Compose the SQL for query
     */
    public function composeSQL(): void
    {
		$this->sql = "INSERT INTO login_activity (".
		    "username, client_ip, proxy_ip, remote_addr, user_agent, success, notes)".
		    " VALUES (?,?,?,?,?,?,?)";
	}

	/**
	 * Save the log to database
	 */
	public function saveToDB(): void
	{
		global $db_username, $db_password, $db_server, $db_name;
        $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

		// Check connection
		if ($conn->connect_error) {
		  error_log("Connection failed: " . $conn->connect_error);
		} 
		
        try{
			$stmt = $conn -> prepare($this->sql);
			$stmt -> bind_param(
			    'sssssss', // 7 strings variables
				$this->username,
				$this->client_ip,
				$this->proxy_ip,
				$this->remote_addr,
				$this->user_agent,
				$this->success,
				$this->notes
			);
			$stmt->execute();
	    } catch (Throwable $t){
	        error_log($t->getMessage());
        }
	}
}
