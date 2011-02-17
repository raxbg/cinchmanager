<?php
    require_once("SetGlobals.php");
    require_once("../lib/Environment.php");
    require_once("../lib/dbHandler.php");
    require_once("../lib/User.php");
    require_once("mainDBCreator.php");
    if(isset($_POST['Email']))
    {
        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$_POST['SecondName'],
                $_POST['LastName'],$_POST['Gender'],$_POST['Address'],1,1,
                "e",$_POST['DefaultLanguage']);
        if($UserIsCreated)
        {
            echo Administrator account was successfuly created;
        }
        else
        {
            echo failed to create administrator account;
        }
    }
?>
