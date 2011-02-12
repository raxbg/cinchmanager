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
		</div>
        <div id="page">
            <?php
            if(isset($_SESSION['userinfo']) && User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
            { 
                if(isset($_POST['CreatorID']))
                {
                    $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['FirstName'],$_POST['LastName'],$_POST['Address'],
                    $_POST['BranchID'],$_POST['CreatorID'],$_POST['EmployeeOrClient'],$_POST['DefaultLanguage']);
                    if($UserIsCreated)
                    {
                        echo "User successfully created. The password was send to the given email.";
                    }
                    else
                    {
                        echo "Failed to create user. Unknown reason...";
                    }
                }
                else
                {
            ?>
            <form method="post">
                <input type="hidden" name="CreatorID" value="<?php echo $_SESSION['userinfo']['ID'];?>">
                <input type="hidden" name="BranchID" value="<?php echo $_SESSION['userinfo']['BranchID'];?>">
                <h2>Account information</h2>
                Email:<br />
                <input type="text" name="Email" /><br />
                First name:<br />
                <input type="text" name="FirstName" /><br />
                Last name:<br />
                <input type="text" name="LastName" /><br />
                Address:<br />
                <textarea name="Address"></textarea><br />
                Type:<br />
                <?php
                    if(!is_null($_SESSION['userinfo']['CanCreateAccounts']))
                    {
                ?>
                <select name="EmployeeOrClient">
                    <?php
                        if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
                        {
                            echo "<option value=\"e\">Employee</option>";
                        }
                    ?>
                    <option value="c">Client</option>
                </select><br />
                <?php
                    }
                ?>
                Default language:<br />
                <select name="DefaultLanguage">
                    <option value="bg">BG</option>
                    <option value="en">EN</option>
                </select><br />
                <?php
                if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
                {
                ?>
                Account can create:<br />
                <select name="CanCreateAccounts">
                    <option value="null">none</option>
                    <option value="a">Everything</option>
                    <option value="c">Only clients</option>
                </select><br />
                <?php
                }
                ?>
                <input type="submit" value="Create"/><br />
            </form>
            <?php
                    }
                }
            elseif(isset($_SESSION['userinfo']) && !User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
            {
                echo "You are not allowed to create new user accounts!";
            }
            else
            {
                echo "Please login first!";
            }
        ?>
        </div>        
    </body>
</html>
