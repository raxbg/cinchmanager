<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] != "n" && Hierarchy::IsXManagerOfY($_GET['id'],$_SESSION['userinfo']['ID']))
{
    if(isset($_POST['NewSalary']))
    {
        $dbHandler= new dbHandler();
        $dbHandler->dbConnect();
        $dbHandler->ExecuteQuery("BEGIN");
        $date=mysql_real_escape_string($_POST['date']);
        $oldDate=mysql_real_escape_string($_POST['oldDate']);
        $id=mysql_real_escape_string($_POST['id']);
        $Salary=mysql_real_escape_string($_POST['NewSalary']);
        $query="UPDATE Salaries
                SET ToDate='{$date}'
                WHERE UserID={$id} AND FromDate='{$oldDate}'";
        $OldRecordIsUpdated = $dbHandler->ExecuteQuery($query);
        echo mysql_error()."<br />";

        $query="INSERT INTO Salaries (UserID, FromDate, Amount)
                Values ('{$id}','{$date}','{$Salary}')";
        $NewRecordIsCreated = $dbHandler->ExecuteQuery($query);
        echo mysql_error();
        if($OldRecordIsUpdated&&$NewRecordIsCreated)
        {
            $dbHandler->ExecuteQuery("COMMIT");
            echo SALARY_UPDATED_TEXT;
        }
        else
        {
            $dbHandler->ExecuteQuery("ROLLBACK");
        }
        $dbHandler->dbDisconnect();
    }
    elseif(isset($_GET['id']))
    {
        $dbHandler= new dbHandler();
        $dbHandler->dbConnect();
        $id=mysql_real_escape_string($_GET['id']);
        $query="SELECT Users.ID, Users.FirstName, Users.LastName,Branches.Name AS Branch, Positions.Position, Salaries.Amount AS Salary, Salaries.FromDate
                FROM Salaries
                LEFT JOIN Users
                ON Users.ID = Salaries.UserID
                LEFT JOIN Employees
                ON Users.ID = Employees.UserID
                LEFT JOIN Positions ON Employees.PositionID = Positions.ID
                LEFT JOIN Branches ON Users.BranchID = Branches.ID
                WHERE Salaries.UserID ={$id}
                ORDER BY Fromdate DESC";
        $result = $dbHandler->ExecuteQuery($query);
        $dbHandler->dbDisconnect();
        $Employee=mysql_fetch_array($result);
        $nextMonth = mktime(0,0,0,date("m")+1,1,date("Y"));
        $NextMonth = date("Y-m-d", $nextMonth)
?>
        <form method="post">
            <h1><?php echo EDIT_SALARY; ?></h1>
            <input type="hidden" name="id" value="<?php echo $Employee['ID']; ?>">
            <input type="hidden" name="oldDate" value="<?php echo $Employee['FromDate']; ?>">
            <?php echo EMPLOYEE_NAME_TEXT; ?><br />
            <input type="text" readonly="readonly" name="name" value="<?php echo $Employee['FirstName']." ".$Employee['LastName']; ?>"><br />
            <?php echo BRANCH_TEXT; ?><br />
            <input type="text" readonly="readonly" name="branch" value="<?php echo $Employee['Branch']; ?>"><br />
            <?php echo POSITION_TEXT; ?><br />
            <input type="text" readonly="readonly" name="position" value="<?php echo $Employee['Position']; ?>"><br />
            New salary:<br />
            <input type="text" name="NewSalary" value="<?php echo $Employee['Salary']; ?>"/><br />
            <?php echo FROM_DATE_TEXT; ?><br />
            <input type="text" name="date" value="<?php echo $NextMonth;?>"/><br />
            <input type="submit" value="<?php echo EDIT_TEXT; ?>" />
        </form>
<?php
    }
    else
    {
        echo EMPLOYEE_NOT_FOUND;
    }
}
elseif(isset($_SESSION['LoggedIn']))
{
    echo NOT_ALLOWED_TO_EDIT_ACCOUNTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>

