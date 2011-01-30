<?php
public class User
{
	private username;
	private fastfogin;
	private firstname;
	private middlename;
	private lastname;
	
	public static function Login($uname,$pwd)
	{
		echo "You are trying to login with username: <b>".$uname."</b>";
		echo " and password: <b>".$pwd."</b>";
	}
}
?>