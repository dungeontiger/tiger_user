<?php
/*
 * Manage passwords for user accounts.
 * 
 * @author Stephen D. Gibson <stephen.d.gibson@gmail.com>
 * 
 */
include_once "UserException.php";
 
class User
{
	/*
	 * Creates a new user object
	 * 
	 * @param $hashFunction String value representing on of the PHP built-in hashing functions, e.g., sha256, md5
	 * @param $saltLength Integer representing how long of a salt to use.  Must be greater than zero.
	 * @param $keyStretch Integer indicating how many times to stretch the key.  Must be greater than or equal to zero.
	 * @throws UserException for invalid parameters.
	 */
	public function User($hashFunction, $saltLength, $keyStretch)
	{
		// check to see if the hash function is valid
		if (!in_array($hashFunction, hash_algos(), true))
		{
			throw new UserException("Invalid hash function: $hashFunction");
		}
		$this->hashFunction = $hashFunction;
		
		// check to see if the salt length is valid
		if (!is_int($saltLength) || $saltLength < 1)
		{
			throw new UserException("Invalid salt length: $saltLength");
		}
		$this->saltLength = $saltLength;

		// check to see if the key stretch is valid
		if (!is_int($keyStretch) || $keyStretch < 0)
		{
			throw new UserException("Invalid key stretch: $keyStretch");
		}
		$this->keyStretch = $keyStretch;
	}
	
	/*
	 * Creates a new user an associates the data with this object
	 * 
	 * @param $userId User identifier. Currently not used for anything just recorded for identification outside this object if necessary
	 * @param $password Password to hash; must not be null or empty
	 * @throws UserException for invalid parameters.
	 */
	public function createUser($userId, $password)
	{
		if (!is_string($userId) || $userId == "")
		{
			throw new UserException("Invalid userId: $userId");
		}
		
		if (!is_string($password) || $password == "")
		{
			throw new UserException("Invalid password: $password");
		}

		$this->userId = $userId;
		$this->setPassword($password);
	}
	
	public function initializeFromStore($userId, $hash, $salt)
	{
		$this->userId = $userId;
		$this->hash = $hash;
		$this->salt = base64_decode($salt);
	}
	
	public function getUserId()
	{
		return $this->userId;
	}
	
	public function getHash()
	{
		return $this->hash;
	}
	
	public function getSalt()
	{
		return base64_encode($this->salt);
	}
	
	public function setPassword($password)
	{
		$this->salt = mcrypt_create_iv($this->saltLength);
		$this->hash = $this->generateHash($password);
	}
	
	public function checkPassword($password)
	{
		$hash = $this->generateHash($password);
		return $this->hash == $hash;
	}
		
	public function getHashFunction()
	{
		return $this->hashFunction;
	}
	
	public function getSaltLength()
	{
		return $this->saltLength;
	}
	
	public function getKeyStretch()
	{
		return $this->keyStretch();
	}
	
	private function generateHash($password)
	{
		$hash = hash($this->hashFunction, $password . $this->salt);
		for ($i = 0; $i < $this->keyStretch; $i++)
		{
			$hash = hash($this->hashFunction, $hash . $password . $this->salt);
		}
		return $hash;
	}
	
	private $userId;
	private $hash;
	private $salt;
	private $hashFunction;
	private $keyStretch;
	private $saltLength;
}
?>
