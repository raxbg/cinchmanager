<?php
class dbHandler
{
	private $host="localhost";
	private $username="cinchmanager";
	private $pwd="cinch";
	
	public function dbConnect();
	{
		$con = mysql_connect($this->host,$this->username,$this->pwd);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
	}
	public function checkUser($uname,$pwd)
	{
		
	}
}
?>