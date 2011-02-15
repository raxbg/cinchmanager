<?php
require_once("lib/LoadSystem.php");
global $TEXT; 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $GLOBALS['COMPANY_NAME'];/*." ".$TEXT['Manager']*/?></title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" language="javascript" src="js/menu.js"></script>

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
		
		<ul id="menu">
			<li class="level_1">
				<a href=#>Users</a>
				<ul id="users_submenu">
					<li class="level_2">
						<a href="">View all users</a>
						<ul id="all_users">
							<li class="level_3">Employees</li>
							<li class="level_3">Clients</li>
						</ul>
					</li>
					<li class="level_2">
						<a href="/CreateAccount.php">Create new account</a>
					</li>
				</ul>
			</li>
			<li class="level_1">
				<a href=#>Settings</a>
			</li>
		</ul>
		
		<div id="page">
        <?php
            if(isset($_POST['logout']))
            {
                echo $TEXT['Goodbye'];             
            }
            else if(isset($_POST['submit_button']))
            {   
               if(isset($_SESSION['LoggedIn']))
               {
                   echo $TEXT['Hello'];
               }
               else
               {
                   echo $TEXT['IncorrectUser'];
               }            
            }
        ?>
	    </div>		
	</body>
</html>