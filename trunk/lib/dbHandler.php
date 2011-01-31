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
	private function EncryptPwd($pwd)
	{
		//$pwd = mysql_real_escape_string($pwd);
		$query = "SELECT SHA1('{$pwd}')";
		$result = mysql_query($query,$con);
		$pwd = mysql_fetch_row($result);
		return $pwd[0];
	}
	public function LoginIsCorrect($uname,$pwd)
	{
		$uname = mysql_real_escape_string($uname);
		$pwd = $this->EncryptPwd($pwd);
		$query = "SELECT Username,Password FROM People WHERE 
		Username = '{$uname}' 
		AND Password = '{$pwd}'";
		$reply = mysql_query($query,$con);
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