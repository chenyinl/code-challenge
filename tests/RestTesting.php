<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include('../src/Rest.php');
final class RestTesting extends TestCase
{
	/* test the hash */
	public function testMatchHashSuccess(): void
	{
		$obj = new Rest();
		$password = 'abcdef';
		$passwordObj = array(
		    'password_hash'=>'eb5a595d84c2d23a92a156590df88002344d6066cd982835c92b0672e45e8646',
		    'password_salt'=>'salt91741'
		);
		$this->assertTrue($obj->matchHash($password, $passwordObj));
	}
	
	/* Test with wrong password */
	public function testMatchHashFails(): void
	{
		$obj = new Rest();
		$password = '12345';
		$passwordObj = array(
		    'password_hash'=>'eb5a595d84c2d23a92a156590df88002344d6066cd982835c92b0672e45e8646',
		    'password_salt'=>'salt91741'
		);
		$this->assertFalse($obj->matchHash($password, $passwordObj));
	}
}
