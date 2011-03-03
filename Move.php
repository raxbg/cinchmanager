<?php
if(isset($_POST['manager']))
{
    echo $_POST['user']."->".$_POST['manager'];
    User::MoveInHierarchy($_POST['user'], $_POST['manager']);
}
else
{
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $usersQuery = "SELECT Users.ID,Users.FirstName,Users.LastName
                        FROM Employees
                        LEFT JOIN Users
                        ON Employees.UserID = Users.ID
                        ORDER BY FirstName, LastName";
    $users = $dbHandler->MakeSelectOptions($usersQuery, "ID", array("FirstName","LastName"));
    $dbHandler->dbDisconnect();
    unset($dbHandler);
?>
<form method="post">
    Give:<input type="text" name="user"><br />
    To:<input type="text" name="manager"><br />
    <input type="submit" value="Move">
</form>
<?php
}

?>
