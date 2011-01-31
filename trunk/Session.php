<?php
session_start();
require_once("lib/LoadSystem.php");
?> 

<html>
<body>
<?php
	if(isset($_POST['goodbye']))
	{
	echo "Goodbye ".$_SESSION['Username']."!";
	session_destroy();
	}
	else if(isset($_SESSION['Username']))
	{
		echo "Hello ".$_SESSION['Username']."!";
?>
	<br />
	<form method="post">
	<input type="submit" name="goodbye" value="Goodbye">
	</form>	
<?php
	}
	else if(isset($_POST['submit_button']))
	{
		User::Login($_POST['Username'],$_POST['Pwd']);
?>
	<br />
	<form method="post">
	<input type="submit" name="goodbye" value="Goodbye">
	</form>	
<?php
	}
	else 
	{
?>
	<form method="post">
	Username: <input type="text" name="Username">
	Password: <input type="text" name="Pwd">
	<input type="submit" name="submit_button" value="Enter">
	</form>	
<?php
	}
?>
</body>
</html> 