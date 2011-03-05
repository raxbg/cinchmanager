<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['id'])&&$_GET['id']!="")
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();
        $TaskID=mysql_real_escape_string($_GET['id']);
            $TaskQuery="SELECT Status FROM Tasks WHERE ID = {$TaskID}";
            $TaskResult=$dbHandler->ExecuteQuery($TaskQuery);
            echo mysql_error();
            $Task=mysql_fetch_array($TaskResult);
            if($Task)
            {

            }
            else
            {
                echo "<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
            }

        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        echo "<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
    }
?>
