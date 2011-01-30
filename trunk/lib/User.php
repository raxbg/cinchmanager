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
	$userExists = $dbHandler->checkUser();
		$_SESSION['Username']=$_POST['Username'];
		echo "Hello ".$_SESSION['Username']."!";
	}
}
?>