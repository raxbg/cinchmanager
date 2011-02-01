<?php
class User
{
	private $username;
	private $fastfogin;
	private $firstname;
	private $middlename;
	private $lastname;
	
	public static function Login($email,$pwd)
	{
		$dbHandler = new dbHandler;
		$dbHandler->dbConnect();
		if($dbHandler->LoginIsCorrect($email,$pwd))
		{
			$_SESSION['Username']=$email;
			echo "Hello ".$_SESSION['Username']."!";
		}
		else
		{
			echo "Incorrect username or password";
		}
		$dbHandler->dbDisconnect();
	}
}
?>