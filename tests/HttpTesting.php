<?php
declare(strict_types=1); // only accept same type of value to a var

use PHPUnit\Framework\TestCase;
require_once ('../config/server.php');

/**
 * Test the API call
 */
final class HttpTesting extends TestCase
{
    /**
     * Login API call - success
     *
     * @param string username
     * @param string password
     *
     * @testWith ["user1", "abcdef"]
     */
    public function testLoginSuccess(string $username, string $password):void
    {
        global $server_name;
        
        $ch = curl_init("http://".$server_name."/api.php");
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "uname=".$username."&psw=".$password);
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $returnObj = json_decode($server_output, true);
        
        curl_close ($ch);

        $this->assertEquals($returnObj['result'], "success");
        $this->assertEquals($returnObj['public_message'], "Login Successed");
    }

    /**
     * Login API call - fail
     *
     * @param string username
     * @param string password
     *
     * @testWith ["user2", "aaaaa"]
     */
    public function testLoginFailed(string $username, string $password):void
    {
        global $server_name;
        $ch = curl_init("http://".$server_name."/api.php");
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "uname=".$username."&psw=".$password);
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $returnObj = json_decode($server_output, true);
        
        curl_close ($ch);
        
        $this->assertEquals($returnObj['result'], "failed");
        $this->assertEquals($returnObj['public_message'], "Login Failed");
    }    
}
