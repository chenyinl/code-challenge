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
    public function log(string $username, string $success, string $notes, mysqli $conn): void
    {
        $this->client_ip   = (!empty($_SERVER['HTTP_CLIENT_IP']))? $_SERVER['HTTP_CLIENT_IP']:"";
        $this->proxy_ip    = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))? $_SERVER['HTTP_X_FORWARDED_FOR']:"";
        $this->remote_addr = (!empty($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR']: "";
        $this->user_agent  = (!empty($_SERVER['HTTP_USER_AGENT']))? $_SERVER['HTTP_USER_AGENT']: "";
        $this->conn        = $conn;
        $this->success     = $success;
        $this->notes       = $notes;
        $this->username    = $username;
        $this->composeSQL();
        $this->saveToDB();
        //var_dump($this->conn);
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
        try{
            $stmt = $this->conn -> prepare($this->sql);
            if(!$stmt){
				throw new Exception('Cannot prepare activities statement.');
			}
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
            $exe_result = $stmt->execute();//var_dump($stmt->error);
            if(!$exe_result){
				throw new Exception('Cannot prepare activities statement.'.
				$stmt->error
				);
			}else{
				//var_dump($stmt->insert_id);
			}
			$stmt->close();
        } catch (Throwable $t){
            error_log($t->getMessage());
        }
    }
}
