<?php
session_start();

require_once("lib/LoadSystem.php");
$user;
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
                        $user = unserialize($_SESSION['user']);
                        unset($_SESSION['LoggedIn']);
                        session_destroy();
					    echo "Goodbye ".$user->Title().$user->LastName()."!";                    
					}
					else if(isset($_SESSION['LoggedIn']))
					{  
                        $user = unserialize($_SESSION['user']);
						echo "Hello ".$user->Title().$user->LastName()."!";
				?>
					<form method="post">
					<input type="submit" name="logout" value="Log out">
					</form>	
				<?php
					}
					else if(isset($_POST['submit_button']))
					{   
						User::Login($_POST['Username'],$_POST['Pwd']);
                        $_SESSION['user']=serialize($user);
				?>
					<form method="post">
					<input type="submit" name="logout" value="Log out">
					</form>	
				<?php
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
									<input type="text" name="Username" value="" style="width:120px;"/>
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