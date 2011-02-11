<?php
    require_once("lib/LoadSystem.php");
    if(isset($_POST['CreatorID']))
    {
        User::CreateAccount($_POST['Email'],$_POST['FirstName'],$_POST['Lastname'],$_POST['Address'],
        $_POST['BranchID'],$_POST['CreatorID'],$_POST['EmployeeOrClient'],$_POST['DefaultLanguage']);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Cinch Manager installator</title>
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>
    <body>
        <div id="header">
        </div>
        <div id="page">
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
                <select name="EmployeeOrClient">
                    <option value="e">Employee</option>
                    <option value="c">Client</option>
                </select><br />
                Default language:<br />
                <select name="DefaultLanguage">
                    <option value="bg">BG</option>
                    <option value="en">EN</option>
                </select><br />
                <input type="submit" value="Create"/><br />
            </form>
        </div>        
    </body>
</html>
