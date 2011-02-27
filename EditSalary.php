<?php
if(isset($_GET['id']))
{
    $dbHandler= new dbHandler();
    $dbHandler->dbConnect();
    $id=mysql_real_escape_string($_GET['id']);
    $query="SELECT Users.FirstName, Users.LastName,Branches.Name AS Branch, Positions.Position, Salaries.Amount AS Salary, Salaries.FromDate
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
    $NextMonth = date("d-m-Y", $nextMonth)
?>
    <form action="post">
        <h1>Edit salary</h1>
        Emplye name:<br />
        <input type="text" readonly="readonly" value="<?php echo $Employee['FirstName']." ".$Employee['LastName']; ?>" name="name"><br />
        Branch:<br />
        <input type="text" readonly="readonly" value="<?php echo $Employee['Branch'] ?>" name="branch"><br />
        Position:<br />
        <input type="text" readonly="readonly" value="<?php echo $Employee['Position'] ?>" name="position"><br />
        New salary:<br />
        <input type="text" name="NewSalary" value="<?php echo $Employee['Salary'] ?>"/><br />
        Date of change:<br />
        <input type="text" name="date" value="<?php echo $NextMonth;?>"/><br />
        <input type="submit" value="Edit" />
    </form>
<?php
}
else
{
    echo EMPLOYEE_NOT_FOUND;
}
?>
