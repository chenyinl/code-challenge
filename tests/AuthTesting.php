<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include('../src/Auth.php');
final class AuthTesting extends TestCase
{
    /* test the hash */
    public function testMatchHashSuccess(): void
    {
        $obj = new Auth();
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
        $obj = new Auth();
        $password = '12345';
        $passwordObj = array(
            'password_hash'=>'eb5a595d84c2d23a92a156590df88002344d6066cd982835c92b0672e45e8646',
            'password_salt'=>'salt91741'
        );
        $this->assertFalse($obj->matchHash($password, $passwordObj));
    }
}
