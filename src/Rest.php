<?php
/**
 * A simple REST API class
 */
class Rest
{
	/**
	 * Check if the password hash matches
	 *
	 * @param string $username The username given, to look up in the DB
	 * @param string $password The password to process the hash
	 */
    public function login (string $username, string $password, mysqli $conn): array
    {
        $passwordObj = $this->lookupDB($username, $conn);
        if(empty($passwordObj)){
            $a = array(
                "result" => "failed",
                "internal_message" => "user not found",
                "public_message"   => "Login Failed"
            );
            return $a;
        }
        if($this->matchHash($password, $passwordObj)){
            $a = array(
                "result" => "success",
                "internal_message" => "password matched",
                "public_message"   => "Login Successed"
            );
            return $a;
            
        }else{
            $a = array(
                "result" => "failed",
                "internal_message" => "hash does not matched",
                "public_message"   => "Login Failed"
            );
            return $a;
        }
    }

    /**
     * Look up the salt and hash from the DB
     *
     * Use Prepare statment to prevent SQL injection
     *
     * @param string $username Look up the DB by user name
     */
    private function lookupDB(string $username, mysqli $conn): array
    {
        /* Set it to read only */
        $conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
        
        /* use prepare statment to prevent SQL injection */
        $sql = "SELECT password_hash, password_salt 
                FROM customers 
                WHERE username=?";
        $stmt = $conn ->prepare($sql);
        $stmt -> bind_param('s', $username);
        $stmt -> execute();

        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if(!$row) return array();
        return $row;
    }

    /**
     * Math the password hash
     *
     * @param string $password The password given by the user
     * @param array $passwordObject The data from database
     */
    public function matchHash(string $password, array $passwordObject): bool
    {
        $hash = hash_hmac("sha256", $password, $passwordObject['password_salt']);
        if($hash == $passwordObject['password_hash']){
            return true;
        }else{
            return false;
        }
    }
}
