<?php
require_once("lib/LoadSystem.php"); 
if(!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started']=true;
}
User::Remember();
if(isset($_COOKIE['Email']))
{
    User::AutoLogin();
}
if(isset($_POST['logout']))
{
    User::Logout();             
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
		<link rel=stylesheet type="text/css" href="css/style.css" />
	</head>
	<body>
		<div id="header">
			<div id="userinfo">
				<?php
                    if(isset($_SESSION['LoggedIn']))
					{
						echo "Hello ".$_SESSION['userinfo']['FirstName']."!";
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
                            require_once("modules/LoginBox.php");
                         }
					}
					else
					{
					    require_once("modules/LoginBox.php");
					}
				?>
			</div>
		</div>
		<div id="page">
        <?php
            if(isset($_POST['logout']))
            {
                echo "Goodbye!";             
            }
            else if(isset($_POST['submit_button']))
            {   
               if(isset($_SESSION['LoggedIn']))
               {
                   echo "Hi!";
               }
               else
               {
                   echo "Incorrect username or password";
               }            
            }
        ?>
	    </div>		
	</body>
</html>