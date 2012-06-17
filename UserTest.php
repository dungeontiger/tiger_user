<?php
/*
 * Unit Test for the User class
 * 
 * @author Stephen D. Gibson <stephen.d.gibson@gmail.com>
 * 
 */
 require "User.php";
 
class UserTest extends PHPUnit_Framework_TestCase
{
	public function testValidCreate()
	{
		$user = new User("sha256", 256, 256);
		$this->assertNotNull($user, "Failed to create object of User.");
	}
	
	public function testBadHashFunction()
	{
		$exception = false;
		try
		{
			$user = new User("sha99", 256, 256);
		}
		catch (Exception $e)
		{
			$exception = true;
		}
		$this->assertTrue($exception, "Expected exception.");
	}
}
?>
