<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class HttpTesting extends TestCase
{
	/* test the hash */
	public function testLoginSuccess():void
	{
		$ch = curl_init("http://localhost/code-challenge/web/api.php");
		
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "uname=user1&psw=abcdef");
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $returnObj = json_decode($server_output, true);
        
        curl_close ($ch);
        
        $this->assertEquals($returnObj['result'], "success");
        $this->assertEquals($returnObj['public_message'], "Login Successed");
	}
	
	/* test with wrong password */
	public function testLoginFailed():void
	{
		$ch = curl_init("http://localhost/code-challenge/web/api.php");
		
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "uname=user2&psw=abcdef");
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $returnObj = json_decode($server_output, true);
        
        curl_close ($ch);
        
        $this->assertEquals($returnObj['result'], "failed");
        $this->assertEquals($returnObj['public_message'], "Login Failed");
	}	
}
