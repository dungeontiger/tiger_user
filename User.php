<?php
/*
 * Manage passwords for user accounts.
 * 
 * @author Stephen D. Gibson <stephen.d.gibson@gmail.com>
 * 
 */
class User
{
	/*
	 * Creates a new user object
	 * 
	 * @param $hashFunction String value representing on of the PHP built-in hashing functions, e.g., sha256, md5
	 * @param $saltLength Integer representing how long of a salt to use.  Must be greater than zero.
	 * @param $keyStretch Integer indicating how many times to stretch the key.  Must be greater than or equal to zero.
	 * @throws Exceptions for invalid parameters.
	 */
	public function User($hashFunction, $saltLength, $keyStretch)
	{
		// check to see if the hash function is valid
		if (!in_array($hashFunction, hash_algos(), true))
		{
			throw new Exception("Invalid hash function: $hashFunction", 1);
		}
		$this->hashFunction = $hashFunction;
		
		// check to see if the salt length is valid
		if (!is_int($saltLength) || $saltLength < 1)
		{
			throw new Exception("Invalid salt length: $saltLength", 2);
		}
		$this->saltLength = $saltLength;

		// check to see if the key stretch is valid
		if (!is_int($keyStretch) || $keyStretch < 0)
		{
			throw new Exception("Invalid key stretch: $keyStretch", 3);
		}
		$this->keyStretch = $keyStretch;
	}

	public function initializeFromStore($userId, $hash, $salt)
	{
		$this->userId = $userId;
		$this->hash = $hash;
		$this->salt = base64_decode($salt);
	}
	
	public function createUser($userId, $password)
	{
		$this->userId = $userId;
		$this->setPassword($password);
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
