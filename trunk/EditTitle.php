<?php
$dbHandler=new dbHandler();
$dbHandler->dbConnect();
$query="SELECT Title FROM Titles";
$result = $dbHandler->ExecuteQuery($query);
while($TitleName = mysql_fetch_row($result))
{
    $titles.=$TitleName[0].", ";
}
$titles=  substr($titles, 0, -2);
?>
<form method="post">
    <h2>Add title</h2>
    <?php echo $titles;?><br />
    <?php echo TITLE_TEXT ?><br />
    <input type="text" name="NewTitleName" /><br />
    <input type="submit" value="<?php echo CREATE_TEXT;?>" />
</form>
