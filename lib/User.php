<?php
class User
{
	private $username;
	private $fastfogin;
	private $firstname;
	private $middlename;
	private $lastname;
	
	public static function Login($uname,$pwd)
	{
		$dbHandler = new dbHandler;
		$dbHandler->dbConnect();
		if($dbHandler->LoginIsCorrect($uname,$pwd))
		{
			$_SESSION['Username']=$uname;
			echo "Hello ".$_SESSION['Username']."!";
		}
		else
		{
			echo "Incorrect username or password";
		}
	}
}
?>