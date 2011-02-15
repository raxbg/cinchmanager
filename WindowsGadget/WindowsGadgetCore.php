<?php
function showUserTasks($userID)
{
    require_once("../lib/dbHandler.php");
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $userID = mysql_real_escape_string($userID);
    $query = "SELECT TaskID FROM TasksAndEmployees WHERE ToUserID = {$userID}";
    $result = $dbHandler->ExecuteQuery($query);
    $tasksNumber = mysql_num_rows($result);
    $dbHandler->dbDisconnect();
    if($tasksNumber > 0)
    {
        echo "You have {$tasksNumber} new tasks.";
    }
}
if(isset($_GET['task']))
{
  if($_GET['task']=="userTasks")
  {
    require_once("../lib/dbHandler.php");
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $userID = mysql_real_escape_string($userID);
    $query = "SELECT TaskID FROM TasksAndEmployees WHERE ToUserID = {$userID}";
    $result = $dbHandler->ExecuteQuery($query);
    $tasksNumber = mysql_num_rows($result);
    $dbHandler->dbDisconnect();
    if($tasksNumber > 0)
    {
        echo "You have {$tasksNumber} new task";
        if($tasksNumber>1)
        {
            echo "s";
        }
    }
  }
}
?>
