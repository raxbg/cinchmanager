<?php
if(isset($_SESSION['LoggedIn']) && User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    if(isset($_POST['Add']))
    {
        if($_POST['NewPositionName'] != NULL && $_POST['NewPositionName'] != "")
        {
            $query = "INSERT INTO Positions (Position) VALUES (\"{$_POST['NewPositionName']}\")";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".POSITION_ADDED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    elseif(isset($_POST['Edit']))
    {
        if($_POST['NewPositionName'] != NULL && $_POST['NewPositionName'] != "")
        {
            $query = "UPDATE Positions SET Position=\"{$_POST['NewPositionName']}\" WHERE Position=\"{$_POST['OldPosition']}\"";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".POSITION_UPDATED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    $query="SELECT Position FROM Positions";
    $result = $dbHandler->ExecuteQuery($query);
    $positionsCount = mysql_num_rows($result);
    $i = 1;
    while($PositionName = mysql_fetch_row($result))
    {
        if($i != $positionsCount)
        {
            $comma = ", ";
        }
        else
        {
            $comma = "";
        }
        $positions.="<li onclick=\"Edit('{$PositionName[0]}')\">{$PositionName[0]}{$comma}</li>\n";
        $i++;
    }
    $dbHandler->dbDisconnect();
    ?>
    <script type="text/javascript">
        var editText = "<?php echo EDIT_TEXT;?>";
        var addText = "<?php echo ADD_TEXT;?>";
    </script>
    <script type="text/javascript" src="/js/EditTitlesAndPositions.js"></script>
    <form method="post">
        <h1><?php echo EDIT_POSITIONS_TEXT ?></h1>
        <?php echo $message ?>
        <h2><?php echo POSITIONS_TEXT ?></h2>
        <ul id="entries">
            <?php echo $positions;?>
        </ul>
        <hr />
        <h2 id="AddHeading"><?php echo ADD_TEXT;?></h2>
        <h2 id="EditHeading" style="display:none;"><?php echo EDIT_TEXT;?></h2>
        <input type="hidden" name="OldPosition" id="Old"/>
        <input type="text" name="NewPositionName" id="NewName" onfocus="checkField()" onblur="stopCheck()"/><br />
        <input type="submit" value="<?php echo ADD_TEXT;?>" name="Add" id="AddBtn" disabled="true"/>
        <button onClick="CancelEdit()" id="cancelBtn">Cancel</button>
    </form>
<?php
}
elseif(isset($_SESSION['LoggedIn']) && !User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    echo NOT_ALLOWED_TO_CREATE_ACCOUNTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>