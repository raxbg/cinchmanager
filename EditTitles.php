<?php
$dbHandler=new dbHandler();
$dbHandler->dbConnect();
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
    $titles.="<li>{$TitleName[0]}{$comma}</li>\n";
    $i++;
}
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
    <h1><?php echo EDIT_TITLES_TEXT ?></h1>
    <h2><?php echo TITLES_TEXT ?></h2>
    <ul id="titles">
        <?php echo $titles;?>
    </ul>
    <hr />
    <h2 id="add_edit"><?php echo ADD_TEXT;?></h2>
    <input type="text" name="NewTitleName" /><br />
    <input type="submit" value="<?php echo ADD_TEXT;?>" name="AddTitle"/>
</form>
