<?php
  if(isset($_SESSION['LoggedIn']))
	{
		echo "{$_TEXT['Welcome']} {$_SESSION['userinfo']['Title']} {$_SESSION['userinfo']['FirstName']} {$_SESSION['userinfo']['LastName']}!";
?>
	<form method="post">
	<input type="submit" name="logout" value="<?php echo $_TEXT['ButtonLogout']; ?>" id="log_out_btn">
	</form>	
<?php
	}
	else if(isset($_POST['submit_button']))
	{   
		 User::Login($_POST['Email'],$_POST['Password']);
     if($_SESSION['LoggedIn'])
     {
        echo "{$_TEXT['Welcome']} {$_SESSION['userinfo']['Title']} {$_SESSION['userinfo']['FirstName']} {$_SESSION['userinfo']['LastName']}!";
        ?>
            <form method="post">
            <input type="submit" name="logout" value="<?php echo $_TEXT['ButtonLogout']; ?>" id="log_out_btn">
            </form>
        <?php  
     }
     else
     {
        require_once("LoginBox.php");
     }
	}
	else
	{
	    require_once("LoginBox.php");
	}
?>