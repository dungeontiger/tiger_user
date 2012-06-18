<?php
/*
 * Unit Test for UserException Class
 */
include_once "UserException.php";

class UserExceptionTest extends PHPUnit_Framework_TestCase
{
	public function testCreate()
	{
		$e = new UserException("message");
		$this->assertEquals($e->getMessage(), "message", "Not the same message we gave it.");
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testThrows()
	{
		throw new UserException("test");
	}
}
?>
