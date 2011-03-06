<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['id']) && $_GET['id']!="")
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
                $CurrentStatus=$Task['Status'];
                $CurrentStatusImg="img/{$CurrentStatus}percent.png";
?>
<form method="post" name="SetStatus" action="index.php?page=Tasks">
    <input type="hidden" name="EditTaskStatus" value="true">
    <input type="hidden" name="NewStatus" id="NewStatus" value="<?php echo $CurrentStatus;?>">
    <input type="hidden" name="TaskID" id="TaskID" value="<?php echo $TaskID;?>">
</form>
<span class="LitleText"><?php echo STATUS1_TEXT; ?></span>
<span class="LitleText" id="PercentText"><?php echo $CurrentStatus;?></span>%<br />
<map name="status">
    <area alt="0%"  shape="rect" coords="0, 0, 20, 30" onmouseover="changeStatus(0)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
    <area alt="20%" shape="rect" coords="20, 0, 40, 30" onmouseover="changeStatus(20)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
    <area alt="40%" shape="rect" coords="40, 0, 60, 30" onmouseover="changeStatus(40)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
    <area alt="60%" shape="rect" coords="60, 0, 80, 30" onmouseover="changeStatus(60)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
    <area alt="80%" shape="rect" coords="80, 0, 100, 30" onmouseover="changeStatus(80)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
    <area alt="100%" shape="rect" coords="100, 0, 120, 30" onmouseover="changeStatus(100)" onmouseout="revertStatus('<?php echo $CurrentStatusImg; ?>',<?php echo $CurrentStatus;?>)" onclick="setStatus()"/>
</map>
<img alt="Status"  src="<?php echo $CurrentStatusImg; ?>" usemap="#status" name="TaskStatus" width="120" height="30"/>

<?php
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
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
