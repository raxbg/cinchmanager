<?php
$dbHandler=new dbHandler();
$dbHandler->dbConnect();
$query="SELECT Title FROM Titles";
$result = $dbHandler->ExecuteQuery($query);
while($TitleName = mysql_fetch_row($result))
{
    $titles.="<li>{$TitleName[0]}</li>\n";
}
$titles=  substr($titles, 0, -2);
if(isset($_POST['AddTitle']))
{
    $query = "INSERT INTO Titles (Title) VALUES ({$_POST['NewTitleName']})";
    $dbHandler->ExecuteQuery($query);
}
elseif(isset($_POST['EditTitle']))
{
    $query = "UPDATE Titles SET Title='{$_POST['NewTitleName']}' WHERE Title={$_COOKIE['OldTitle']}";
    $dbHandler->ExecuteQuery($query);
}
$dbHandler->dbDisconnect();
?>
<form method="post">
    <h2>Add title</h2>
    <ul>
        <?php echo $titles;?>
    </ul>
    <hr>
    <?php echo TITLE_TEXT ?><br />
    <input type="text" name="NewTitleName" /><br />
    <input type="submit" value="<?php echo CREATE_TEXT;?>" name="AddTitle"/>
</form>
