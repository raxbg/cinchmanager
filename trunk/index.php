<?php
require_once("lib/LoadSystem.php");
global $TEXT; 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $GLOBALS['CompanyName'];/*." ".$TEXT['Manager']*/?></title>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
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