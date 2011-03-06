<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['TaskId'])&&$_GET['TaskId']!="")
    {
?>
<form method="post">
    <input type="hidden" name="TaskID" />
    <textarea name="Comment"></textarea><br />
    <input type="submit" name="SubmitComment" value="<?php echo SUBMIT_TEXT; ?>"/>
</form>

<?php
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
