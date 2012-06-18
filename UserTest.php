<?php
/*
 * Unit Test for the User class
 * 
 * @author Stephen D. Gibson <stephen.d.gibson@gmail.com>
 * 
 */
 
include_once "User.php";
include_once "UserException.php";
 
class UserTest extends PHPUnit_Framework_TestCase
{
	//
	// The following tests are for the constructor its parameters
	//
	public function testValidCreate()
	{
		$user = new User("sha256", 256, 256);
		$this->assertNotNull($user, "Failed to create object of User.");
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testBadHashFunction()
	{
		$user = new User("sha99", 256, 256);
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testNullHashFunction()
	{
		$user = new User(null, 256, 256);
	}

	/**
	 * @expectedException UserException
	 */
	public function testEmptyHashFunction()
	{
		$user = new User(null, 256, 256);
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testNullSaltLength()
	{
		$user = new User("sha256", null, 256);
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testStringSaltLength()
	{
		$user = new User("sha256", "10", 256);
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testNegativeSaltLength()
	{
		$user = new User("sha256", -10, 256);
	}
	
	/**
	 * @expectedException UserException
	 */
	public function testZeroSaltLength()
	{
		$user = new User("sha256", -10, 0);
	}

	/**
	 * @expectedException UserException
	 */
	public function testFloatSaltLength()
	{
		$user = new User("sha256", 256.6, 256);
	}

	/**
	 * @expectedException UserException
	 */
	public function testNullKeyStretch()
	{
		$user = new User("sha256", 256, null);
	}

	/**
	 * @expectedException UserException
	 */
	public function testStringKeyStretch()
	{
		$user = new User("sha256", 256, "1024");
	}

	/**
	 * @expectedException UserException
	 */
	public function testNegativeKeyStretch()
	{
		$user = new User("sha256", 256, -1024);
	}

	/**
	 * @expectedException UserException
	 */
	public function testFloatKeyStretch()
	{
		$user = new User("sha256", 256, 1024.5);
	}

	// 
	// The following tests related to creating a user
	//
	public function testCreateUser()
	{
		$user = new User("md5", 1, 1);
		$user->createUser("user", "admin1234");
	}

	/**
	 * @expectedException UserException
	 */
	public function testCreateUserNullId()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser(null, "admin1234");
	}

	/**
	 * @expectedException UserException
	 */
	public function testCreateUserEmptyId()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser("", "admin1234");
	}

	/**
	 * @expectedException UserException
	 */
	public function testCreateUserIntId()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser(56, "admin1234");
	}

	/**
	 * @expectedException UserException
	 */
	public function testCreateUserFloatId()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser(56.0098, "admin1234");
	}

	/**
	 * @expectedException UserException
	 */
	public function testNullPassword()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser("user", null);
	}

	/**
	 * @expectedException UserException
	 */
	public function testEmptyPassword()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser("user", "");
	}

	/**
	 * @expectedException UserException
	 */
	public function testIntPassword()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser("user", 456);
	}

	/**
	 * @expectedException UserException
	 */
	public function testFloatPassword()
	{
		$user = new User("sha1", 10, 10);
		$user->createUser("user", 456.567);
	}

	public function testGetUserIdFromCreate()
	{
		$user = new User("sha1", 1, 1);
		$user->createUser("user", "admin1234");
		$this->assertEquals($user->getUserId(), "user", "Not the user id passed to it.");
	}
	
	public function testCheckPassword()
	{
//		$user = new User("sha1", 10, 10);
//		$user->createUser("user", "admin1234");
//		$user->checkPassword("admin1234");
	}
	
	//
	// The following tests are for the initializeFromStore method
	//
	public function testInit()
	{
//		$user = new User("sha1", 10, 10);
//		$user->initializeFromStore("myUser");
	}

}
?>
