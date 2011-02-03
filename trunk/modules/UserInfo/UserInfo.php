<?php
  if(isset($_SESSION['LoggedIn']))
	{
		echo "Hello {$_SESSION['userinfo']['Title']} {$_SESSION['userinfo']['FirstName']}!";
?>
	<form method="post">
	<input type="submit" name="logout" value="Log out">
	</form>	
<?php
	}
	else if(isset($_POST['submit_button']))
	{   
		 User::Login($_POST['Email'],$_POST['Password']);
     if($_SESSION['LoggedIn'])
     {
        echo "Hello ".$_SESSION['userinfo']['FirstName']."!";
        ?>
            <form method="post">
            <input type="submit" name="logout" value="Log out">
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