<?php
session_start();
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
		$_SESSION['Username']=$_POST['Username'];
		echo "Hello ".$_SESSION['Username']."!";
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
	<input type="submit" name="submit_button" value="Enter">
	</form>	
<?php
	}
?>
</body>
</html> 