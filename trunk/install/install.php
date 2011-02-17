<?php
    require_once("SetGlobals.php");
    require_once("../lib/Environment.php");
    require_once("../lib/dbHandler.php");
    require_once("../lib/User.php");
    require_once("mainDBCreator.php");
    if(isset($_POST['Email']))
    {
        $null = "NULL";
        $UserIsCreated = User::CreateAccount($_POST['Email'],$null,$_POST['FirstName'],$null,
                $_POST['LastName'],$null,$null,1,1,
                "e",$_POST['DefaultLanguage']);
        if($UserIsCreated)
        {
            echo "Administrator account was successfuly created";
        }
        else
        {
            echo "Failed to create administrator account";
        }
    }
?>
