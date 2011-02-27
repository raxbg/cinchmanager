<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] != "n")
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    if(isset($_POST['Add']))
    {
        if($_POST['NewTitleName'] != NULL && $_POST['NewTitleName'] != "")
        {
            $_POST['NewTitleName'] = mysql_real_escape_string($_POST['NewTitleName']);

            $query = "INSERT INTO Titles (Title) VALUES (\"{$_POST['NewTitleName']}\")";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".TITLE_ADDED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    elseif(isset($_POST['Edit']))
    {
        if($_POST['NewTitleName'] != NULL && $_POST['NewTitleName'] != "")
        {
            $_POST['NewTitleName'] = mysql_real_escape_string($_POST['NewTitleName']);
            $_POST['OldTitle'] = mysql_real_escape_string($_POST['OldTitle']);

            $query = "UPDATE Titles SET Title=\"{$_POST['NewTitleName']}\" WHERE Title=\"{$_POST['OldTitle']}\"";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".TITLE_UPDATED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    $query="SELECT Title FROM Titles";
    $result = $dbHandler->ExecuteQuery($query);
    $titlesCount = mysql_num_rows($result);
    $i = 1;
    while($TitleName = mysql_fetch_row($result))
    {
        if($i != $titlesCount)
        {
            $comma = ", ";
        }
        else
        {
            $comma = "";
        }
        $titles.="<li onclick=\"Edit('{$TitleName[0]}')\">{$TitleName[0]}{$comma}</li>\n";
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
        <h1><?php echo EDIT_TITLES_TEXT ?></h1>
        <?php echo $message ?>
        <h2><?php echo TITLES_TEXT ?></h2>
        <ul id="entries">
            <?php echo $titles;?>
        </ul>
        <hr />
        <h2 id="AddHeading"><?php echo ADD_TEXT;?></h2>
        <h2 id="EditHeading" style="display:none;"><?php echo EDIT_TEXT;?></h2>
        <input type="hidden" name="OldTitle" id="Old"/>
        <input type="text" name="NewTitleName" id="NewName" onfocus="checkField()" onblur="stopCheck()"/><br />
        <input type="submit" value="<?php echo ADD_TEXT;?>" name="Add" id="AddBtn" disabled="true"/>
        <button onClick="CancelEdit()" id="cancelBtn"><?php echo CANCEL_TEXT?></button>
    </form>
<?php
}
elseif(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] == "n")
{
    echo NOT_ALLOWED_TO_CREATE_ACCOUNTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>