<?php
if(isset($_SESSION['LoggedIn']))
{
    if($_SESSION['userinfo']['CanCreateAccounts'] != "n")
    {
        $CanCreateAndEditAccounts=true;
    }
    else
    {
        $CanCreateAndEditAccounts=false;
    }
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    $query="SELECT Users.ID, Users.FirstName, Users.LastName, Branches.Name AS Branch, Users.Email, Users.Telephone
            FROM Users
            LEFT JOIN Branches ON Users.BranchID = Branches.ID
            WHERE Users.EmployeeOrClient='c'
            ORDER BY Branch ASC, FirstName ASC, LastName ASC";
    $Clients="";
    $result = $dbHandler->ExecuteQuery($query);
    $i=0;
    while($employee = mysql_fetch_array($result))
    {
        if ($i%2==0)
        {
            $class="class=\"odd ActiveField\"";
        }
        else
        {
            $class="class=\"even ActiveField\"";
        }
        $i++;

        $Clients.="<tr {$class} onClick=\"PopUpBox('./UserInfo.php?id={$employee['ID']}')\" >\n<td>{$employee['FirstName']} {$employee['LastName']}</td>\n".
        "<td>{$employee['Branch']}</td>\n".
        "<td>{$employee['Email']}</td>\n".
        "<td>{$employee['Telephone']}</td>\n";
        if($CanCreateAndEditAccounts)
        {
            $Clients.="<td class=\"editBtn\"><a href=\"index.php?page=EditAccount&id={$employee['ID']}\"><img src=\"img/edit.gif\"></a></td>\n";
        }
        $Clients.="</tr>\n";
    }
    $dbHandler->dbDisconnect();
?>
    <h1><?php echo CLIENTS_TEXT ?></h1>
    <table class="cooltable">
        <thead>
            <tr>
                <td><?php echo NAME_TEXT ?></td>
                <td><?php echo BRANCH1_TEXT ?></td>
                <td><?php echo EMAIL1_TEXT ?></td>
                <td><?php echo TELEPHONE1_TEXT ?></td>
                <?php
                    if($CanCreateAndEditAccounts)
                    {
                        echo "<td>".EDIT_TEXT."</td>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php echo $Clients ?>
        </tbody>
    </table>

<?php
    if($CanCreateAndEditAccounts)
    {
        echo "<a href=\"index.php?page=CreateAccount\">".CREATE_ACCOUNT_TEXT."</a>";
    }
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>

