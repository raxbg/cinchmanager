<?php
    global $TEXT;
  if(isset($_SESSION['LoggedIn']))
	{
		echo "{$TEXT['Welcome']} {$_SESSION['userinfo']['Title']} {$_SESSION['userinfo']['FirstName']} {$_SESSION['userinfo']['LastName']}!";
?>
	<form method="post">
	<input type="submit" name="logout" value="<?php echo $TEXT['ButtonLogout']; ?>" id="log_out_btn">
	</form>	
<?php
	}
	else
	{
	    require_once("LoginBox.php");
	}
?>