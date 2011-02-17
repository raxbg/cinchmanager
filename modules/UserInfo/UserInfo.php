<?php
  if(isset($_SESSION['LoggedIn']))
	{
		echo WELCOME_TEXT." {$_SESSION['userinfo']['Title']} {$_SESSION['userinfo']['FirstName']} {$_SESSION['userinfo']['LastName']}!";
?>
	<form method="post">
            <input type="submit" name="logout" value="<?php echo BUTTON_LOGOUT_TEXT; ?>" id="log_out_btn">
	</form>	
<?php
	}
	else
	{
	    require_once("LoginBox.php");
	}
?>