<?php
/*
 * Exceptions raised by the User class
 * 
 * @author Stephen D. Gibson <stephen.d.gibson@gmail.com>
 * 
*/
class UserException extends Exception
{
	public function UserException($msg)
	{
		parent::__construct($msg);
	}
}
?>
