<?php
if(isset($_SESSION['LoggedIn']))
{
    if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
    {
        $CanCreateAndEditAccounts=true;
    }
    else
    {
        $CanCreateAndEditAccounts=false;
    }

    if(isset($_POST['Dismiss']))
    {
        if(Hierarchy::Dismiss($_POST['UserID']))
        {
            echo "<span class=\"PositiveMessage\">".DISMISSED_TEXT."</span>";
        }
        else
        {
            echo "<span class=\"NegativeMessage\">".COULD_NOT_DISSMISS_TEXT."</span>";
        }
    }

    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    $query="SELECT Users.ID, Users.FirstName, Users.LastName, Branches.Name AS Branch, Positions.Position, Users.Email, Users.Telephone, Employees.EndDate
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
        if($employee['EndDate'])
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

            $Employees.="<tr {$class} onClick=\"PopUpBox('./UserInfo.php?id={$employee['ID']}')\" >\n<td>{$employee['FirstName']} {$employee['LastName']}</td>\n".
            "<td>{$employee['Position']}</td>\n".
            "<td>{$employee['Branch']}</td>\n".
            "<td>{$employee['Email']}</td>\n".
            "<td>{$employee['Telephone']}</td>\n";
            $Employees.="</tr>\n";
        }
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);
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