<?php
require_once("lib/LoadSystem.php"); 
if(!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started']=true;
}
User::Remember();
if(isset($_POST['logout']))
{
    User::Logout();             
}
if(isset($_COOKIE['Email']))
{
    User::AutoLogin();
}
if(isset($_GET['language']))
{
    Environment::SetLanguageCookie($_GET['language']);
}
Environment::SetLanguage();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
		<link rel=stylesheet type="text/css" href="css/style.css" />
	</head>
	<body>
		<div id="header">
      <?php      	
      	require_once("modules/Languages/languages.php");    
      ?>
			<div id="userinfo">
				<?php
					require_once("modules/UserInfo/UserInfo.php");
				?>
			</div>
		</div>
		<div id="page">
        <?php
            if(isset($_POST['logout']))
            {
                echo $_TEXT['Goodbye'];             
            }
            else if(isset($_POST['submit_button']))
            {   
               if(isset($_SESSION['LoggedIn']))
               {
                   echo $_TEXT['Hello'];
               }
               else
               {
                   echo $_TEXT['IncorrectUser'];
               }            
            }
        ?>
	    </div>		
	</body>
</html>