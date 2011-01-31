<?php
class dbHandler
{
	private $host="localhost";
	private $username="cinchmanager";
	private $pwd="cinch";
	private $con;
	
	public function dbConnect()
	{
		$this->con = mysql_connect($this->host,$this->username,$this->pwd);
		if (!$this->con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  mysql_select_db("BigTest", $this->con);
	}
	public function dbDisconnect()
	{
		mysql_close($this->con);
	}
	private function EncryptPwd($pwd)
	{
		$pwd = mysql_real_escape_string($pwd);
		$query = "SELECT SHA1('{$pwd}')";
		$result = mysql_query($query,$this->con);
		$pwd = mysql_fetch_row($result);
		return $pwd[0];
	}
	public function LoginIsCorrect($uname,$pwd)
	{
		$uname = mysql_real_escape_string($uname);
		$pwd = $this->EncryptPwd($pwd);
		$query = "SELECT Username,Password FROM People WHERE Username = '{$uname}' AND Password = '{$pwd}'";
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