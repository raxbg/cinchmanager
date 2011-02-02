<?php
if(!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started']=true;
}
if(isset($_POST['RememberMe']) && !is_null($_POST['RememberMe']))
    {
        $userInfo = array
        (
        "Email"=>$_POST['Email'],
        "Password"=>$_POST['Pwd']
        );
        $userInfo = serialize($userInfo);
        $expire=time()+3600;
        $path='';
        $domain='';
        $secure=false;
        $httponly=true;
        setcookie("Info",$userInfo,$expire,$path,$domain,$secure,$httponly);
    }
if(isset($_COOKIE['Info']))
{
    if(get_magic_quotes_gpc())
    {
        $userInfo = unserialize(stripslashes($_COOKIE['Info']));
    }
    else
    {
        $userInfo = unserialize($_COOKIE['Info']);
    }
    echo $userInfo['Email'];
}
require_once("lib/LoadSystem.php");
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
					if(isset($_POST['logout']))
					{
						echo "Hello ".$_SESSION['userinfo']['FirstName']."!";
                        session_destroy();             
					}
					else if(isset($_SESSION['LoggedIn']))
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
						User::Login($_POST['Email'],$_POST['Pwd']);
				        echo "\n</form>";
					}
					else
					{
				?>
					<form method="post">
						<table>
							<tr>
								<td>Email:</td>
								<td>Password:</td>
							</tr>
							<tr>
								<td>
									<input type="text" name="Email" value="" style="width:120px;"/>
								</td>
								<td>
									<input type="password" name="Pwd" value="" style="width:100px;"/>
								</td>
								<td>
									<input type="submit" name="submit_button" value="Enter">
								</td>
							</tr>
							<tr>
								<td colspan=3>
									<input type="checkbox" name="RememberMe" value="0" style="margin:0;border:0"/> Remember me
									<span id="forgotten"><a href=#>Forgotten password</a></span>
								</td>
							</tr>
						</table>
					</form>	
				<?php
					}
				?>
			</div>
		</div>
		<div id="page">
	</div>		
	</body>
</html>