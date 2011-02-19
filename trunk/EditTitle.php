<?php
$dbHandler=new dbHandler();
$dbHandler->dbConnect();
$query="SELECT * FROM Titles";
$result = mysql_fetch_array($dbHandler->ExecuteQuery($query));
foreach ($result as $title)
{
    $titles.=$title.", ";
}
$titles=  substr($titles, 0, -2);
?>
<form method="post">
    <h2>Add title</h2>
    <?php echo $titles;?>
    <?php echo TITLE_TEXT ?><br />
    <input type="text" name="NewTitleName" /><br />
    <input type="submit" value="<?php echo CREATE_TEXT;?>" />
</form>
