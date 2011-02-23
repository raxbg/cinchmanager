<?php
$message="";
$dbHandler=new dbHandler();
$dbHandler->dbConnect();
if(isset($_POST['AddTitle']))
{
    echo "Added";
    $query = "INSERT INTO Titles (Title) VALUES (\"{$_POST['NewTitleName']}\")";
    $dbHandler->ExecuteQuery($query);
    $message = "<span class=\"PositiveMessage\">".TITLE_ADDED_TEXT."</span>";
}
elseif(isset($_POST['EditTitle']))
{
    $query = "UPDATE Titles SET Title=\"{$_POST['NewTitleName']}\" WHERE Title=\"{$_POST['OldTitle']}\"";
    $dbHandler->ExecuteQuery($query);
    $message = "<span class=\"PositiveMessage\">".TITLE_UPDATED_TEXT."</span>";
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
<script type="text/javascript" src="/js/EditTitles.js"></script>
<form method="post">
    <h1><?php echo EDIT_TITLES_TEXT ?></h1>
    <h2><?php echo TITLES_TEXT ?></h2>
    <?php echo $message ?>
    <ul id="titles">
        <?php echo $titles;?>
    </ul>
    <hr />
    <h2 id="AddHeading"><?php echo ADD_TEXT;?></h2>
    <h2 id="EditHeading" style="display:none;"><?php echo EDIT_TEXT;?></h2>
    <input type="hidden" name="OldTitle" id="Old"/>
    <input type="text" name="NewTitleName" id="NewName" /><br />
    <input type="submit" value="<?php echo ADD_TEXT;?>" name="AddTitle" id="AddBtn"/>
    <input type="submit" value="<?php echo EDIT_TEXT;?>" name="EditTitle" id="EditBtn" style="display:none;" />
</form>
