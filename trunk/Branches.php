<?php
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
        "<td>{$branch['Telephone']}</td>\n".
        "<td class=\"editBtn\"><a href=\"index.php?page=EditBranches&id={$branch['ID']}\"><img src=\"img/edit.gif\"></a></td></tr>";
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
            <td><?php echo EDIT_TEXT ?></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $Branches ?>
    </tbody>
</table>
<a href="<?php echo Environment::SetGetVariable("page","EditBranches")?>&AddNew=true"><?php echo ADD_NEW_BRANCH_TEXT ?></a>