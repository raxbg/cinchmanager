<?php
    require_once("SetGlobals.php");
    require_once("../lib/Environment.php");
    require_once("../lib/dbHandler.php");
    require_once("../lib/User.php");
    require_once("mainDBCreator.php");
    if(isset($_POST['Email']))
    {
        $null = "";
        $today = date("Y-m-d");

        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$null,
                $_POST['LastName'],$null,$null,$null,1,1,
                "e",$_POST['DefaultLanguage']);
        $EmployeeIsCreated = Hierarchy::AddToHierarchy("none",1,1,"a",1,$today,"0");
        if($UserIsCreated && $EmployeeIsCreated)
        {
            $message = "<span class=\"PositiveMessage\">";
            $message.= "Administrator account was successfully created.";
            $message.= "</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">";
            $message.= "Failed to create administrator account. Please empty the database and repeat the instalation.";
            $message.= "</span>";
        }
    }
?>
