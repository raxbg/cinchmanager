<?php
class dbHandler
{
	private $host="localhost";
	private $email="cinchman";
	private $pwd="cinch";
	private $con;
	private $db="cinchman_db";
	
	public function connection()
	{
		return $this->con;
	}
	
	public function dbConnect()
	{
		$this->con = mysql_connect($this->host,$this->email,$this->pwd);
		if (!$this->con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  mysql_select_db($this->db, $this->con);
	}
	public function dbDisconnect()
	{
		mysql_close($this->con);
	}
	private function EncryptPwd($pwd)
	{
		$pwd = mysql_real_escape_string($pwd);
		$query = "SELECT SHA1('{$pwd}')";
		$result = mysql_query($query);
		$pwd = mysql_fetch_row($result);
		return $pwd[0];
	}
	public function LoginIsCorrect($email,$pwd)
	{
		$email = mysql_real_escape_string($email);
		$pwd = $this->EncryptPwd($pwd);
		$query = "SELECT Email,Password FROM Users WHERE 
		Email = '{$email}' 
		AND Password = '{$pwd}'";
		$reply = mysql_query($query,$this->con);
		$userIsCorrect = mysql_num_rows($reply);
		if($userIsCorrect == 1) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>