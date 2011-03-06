<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_POST['SubmitComment']))
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();
        $TaskId = mysql_real_escape_string($_POST['TaskId']);
        $Comment = mysql_real_escape_string($_POST['Comment']);
        $UserId = mysql_real_escape_string($_SESSION['userinfo']['ID']);
        $query="INSERT INTO Comments( Comment, UserID, TaskID )
            VALUES('{$Comment}',{$UserId},'{$TaskId}')";
        $dbHandler->ExecuteQuery($query);
        $dbHandler->dbDisconnect();
        unset($dbHandler);

    }

    if(isset($_GET['TaskId'])&&$_GET['TaskId']!="")
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();
        $TaskId = mysql_real_escape_string($_GET['TaskId']);
        $query="SELECT Comments.Comment, Comments.Time, CONCAT(Users.FirstName,' ',Users.LastName) AS User FROM Comments 
                LEFT JOIN Users ON Users.ID = Comments.UserID
                WHERE TaskID={$TaskId}";
        $result = $dbHandler->ExecuteQuery($query);
        echo mysql_error();
        $Comments="";
        while($comment =  mysql_fetch_array($result))
        {
            $Comments.="<span class=\"LittleText\">{$comment['User']}</span>".
            "<span class=\"LittleText right\">{$comment['Time']}</span>".
            "<span class=\"comment\">{$comment['Comment']}</span><hr />";

        }
        $dbHandler->dbDisconnect();
        unset($dbHandler);
?>
<div class="Comments">
    <div class="ComentsInner">
        <?php echo $Comments; ?>
    </div>
</div>
<input type="hidden" name="TaskId" value="<?php echo $_GET['TaskId'];?>" />
<textarea name="Comment" class="comment" id="Comment"></textarea><br />
<button onclick="Comment(<?php echo $_GET['TaskId'];?>)"><?php echo COMMENT_TEXT; ?></button>

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
