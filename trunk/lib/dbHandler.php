<?php
class dbHandler
{
	private $host="localhost";
	private $email="cinchman";
	private $password="cinch";
	private $con;
	private $db="cinchman_db";
	
	public function dbConnect()
	{
		$this->con = mysql_connect($this->host,$this->email,$this->password);
		if (!$this->con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		mysql_select_db($this->db, $this->con);
	}
    
    public function RecordLogin($userID)
    {
        $query = "INSERT INTO Logins (UserID) VALUES ('{$userID}')";
        mysql_query($query,$this->con);
    }
    
	private function EncryptPwd($password)
	{
		$password = mysql_real_escape_string($password);
		$query = "SELECT SHA1('{$password}')";
		$result = mysql_query($query);
		$password = mysql_fetch_row($result);
		return $password[0];
	}
	public function LoginIsCorrect($email,$password)
	{
		$email = mysql_real_escape_string($email);
		$password = $this->EncryptPwd($password);
		$query = "SELECT Users.*,Titles.Title FROM Users 
        LEFT JOIN Titles 
        ON Users.TitleID = Titles.ID 
        WHERE Email = '{$email}' 
		AND Password = '{$password}'";
		$reply = mysql_query($query,$this->con);
		$userIsCorrect = mysql_num_rows($reply);
		if($userIsCorrect == 1) 
		{
			return $reply;
		}
		else
		{
			return false;
		}
	}
    
    public function dbDisconnect()
    {
        mysql_close($this->con);
    }
    
    public function Connection()
    {
        return $this->con;
    }
}
?>