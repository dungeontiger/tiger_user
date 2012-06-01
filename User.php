<?php
class User
{
	public function User()
	{
		global $controller;
		$this->config = $controller->getConfig();
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
		$this->salt = mcrypt_create_iv($this->config->getSaltLength());
		$this->hash = $this->generateHash($password);
	}
	
	public function checkPassword($password)
	{
		$hash = $this->generateHash($password);
		return $this->hash == $hash;
	}
		
	private function generateHash($password)
	{
		$hash = hash($this->config->getHashFunction(), $password . $this->salt);
		for ($i = 0; $i < $this->config->getKeyStretch(); $i++)
		{
			$hash = hash($this->config->getHashFunction(), $hash . $password . $this->salt);
		}
		return $hash;
	}
	
	private $userId;
	private $hash;
	private $salt;
	private $config;
}
?>
