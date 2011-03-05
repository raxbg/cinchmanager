<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['id'])&&$_GET['id']!="")
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();
        $TaskID=mysql_real_escape_string($_GET['id']);
            $TaskQuery="SELECT * FROM Tasks Where ID = {$TaskID}";
            $TaskResult=$dbHandler->ExecuteQuery($TaskQuery);
            $Task=mysql_fetch_array($TaskResult);
            if($Task)
            {
                switch ($Task['Priority'])
                {
                    case 1:
                        $Priority = URGENT_TEXT;
                        break;
                    case 2:
                        $Prioriry = HIGH_PRIORITY_TEXT;
                        break;
                    case 3:
                        $Prioriry = NORMAL_PRIORITY_TEXT;
                        break;
                    case 4:
                        $Prioriry = LOW_PRIORITY_TEXT;
                        break;
                    case 5:
                        $Prioriry = LOWEST_PRIORITY_TEXT;
                        break;
                    default:
                        $Prioriry = NORMAL_PRIORITY_TEXT;
                }
?>
<table>
    <tr>
        <td><?php echo PRIORITY_TEXT; ?></td>
    </tr>
    <tr>
        <td><?php echo $Prioriry; ?></td>
    </tr>
</table>
<h2><?php echo $Task['ShortDescription']; ?></h2>

<?php
            }
            else
            {
                $message.="<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
            }
       
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        echo "<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
