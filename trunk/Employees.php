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
    $query="SELECT Users.ID, Users.FirstName, Users.LastName, Branches.Name AS Branch, Positions.Position, Users.Email, Users.Telephone
            FROM Employees
            LEFT JOIN Users ON Users.ID = Employees.UserID
            LEFT JOIN Positions ON Employees.PositionID = Positions.ID
            LEFT JOIN Branches ON Users.BranchID = Branches.ID
            ORDER BY Branch ASC, FirstName ASC, LastName ASC";
    $Employees="";
    $result = $dbHandler->ExecuteQuery($query);
    $i=0;
    while($employee = mysql_fetch_array($result))
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

        $Employees.="<tr {$class}>\n<td>{$employee['FirstName']} {$employee['LastName']}</td>\n".
        "<td>{$employee['Position']}</td>\n".
        "<td>{$employee['Branch']}</td>\n".
        "<td>{$employee['Email']}</td>\n".
        "<td>{$employee['Telephone']}</td>\n";
        if($CanCreateAndEditAccounts)
        {
            $Employees.="<td class=\"editBtn\"><a href=\"index.php?page=EditAccount&id={$employee['ID']}\"><img src=\"img/edit.gif\"></a></td>\n";
        }
        $Employees.="</tr>\n";
    }
    $dbHandler->dbDisconnect();
?>
    <h1><?php echo EMPLOYEES_TEXT ?></h1>
    <table class="cooltable">
        <thead>
            <tr>
                <td><?php echo NAME_TEXT ?></td>
                <td><?php echo POSITION1_TEXT ?></td>
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
            <?php echo $Employees ?>
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