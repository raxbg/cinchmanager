<?php
if(isset($_SESSION['LoggedIn']))
{
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    $query="SELECT * FROM Branches";
    $Branches="";
    $result = $dbHandler->ExecuteQuery($query);
    $i=0;
    while($branch = mysql_fetch_array($result))
    {
        if ($i%2==0)
        {
            $class="class=\"odd\"";
        }
        else
        {
            $class="class=\"even\"";
        }
        $i++;

        $Branches.="<tr {$class}><td>{$branch['Name']}</td>\n".
        "<td>{$branch['Address']}</td>\n".
        "<td>{$branch['Telephone']}</td>\n";
        if($_SESSION['userinfo']['IsAdmin'])
        {
            $Branches .= "<td class=\"editBtn\"><a href=\"index.php?page=EditBranches&id={$branch['ID']}\"><img src=\"img/edit.gif\"></a></td>\n";
        }
        $Branches .= "</tr>";
    }
    $dbHandler->dbDisconnect();
?>
<h1><?php echo BRANCHES_TEXT ?></h1>
<table class="cooltable">
    <thead>
        <tr>
            <td><?php echo NAME_TEXT ?></td>
            <td><?php echo ADDRESS1_TEXT ?></td>
            <td><?php echo TELEPHONE1_TEXT ?></td>
            <?php
            if($_SESSION['userinfo']['IsAdmin'])
            {
                echo "<td>".EDIT_TEXT."</td>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php echo $Branches ?>
    </tbody>
</table>
<a href="index.php?page=EditBranches"><?php echo ADD_NEW_BRANCH_TEXT ?></a>
<?php
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>