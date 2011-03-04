<?php
    require_once("SetGlobals.php");
    require_once("../lib/Environment.php");
    require_once("../lib/dbHandler.php");
    require_once("../lib/User.php");
    require_once("mainDBCreator.php");
    if(isset($_POST['Email']))
    {
        $null = "NULL";
        $today = date("Y-m-d");
        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$null,
                $_POST['LastName'],$null,$null,$null,1,1,
                "e",$_POST['DefaultLanguage']);
        $EmployeeIsCreated = Hierarchy::AddToHierarchy("none",1,1,"a",1,$today,"0");
        if($UserIsCreated && $EmployeeIsCreated)
        {
            echo ADMINISTRATOR_SUCCESSFULLY_CREATED_TEXT;
        }
        else
        {
            echo FAILED_TO_CREATE_ADMINISTRATOR;
        }
    }
?>
