<?php
function MoveInHierarchy($user,$toManager)
    {
        //$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $user = mysql_real_escape_string($user);
        $toManager = mysql_real_escape_string($toManager);

        $query="SELECT rgt, lft FROM Employees WHERE UserID='{$user}'";
        $result = $dbHandler->ExecuteQuery($query);
        $result = mysql_fetch_array($result);
        $myRight = $result['rgt'];
        $myLeft = $result['lft'];
        $myWidth = ($result['rgt']-$result['lft'])+1;

        $query="SELECT lft,rgt FROM Employees WHERE UserID = '{$toManager}'";
        $result = $dbHandler->ExecuteQuery($query);
        $result = mysql_fetch_array($result);
        $myNewLeft = $result['lft'];
        $myNewRight = $result['rgt'];

        if($myRight>$myNewRight)
        {
            $myNewStartRight = $myNewRight;
        }
        else
        {
            $myNewStartRight = $myNewRight-$myWidth;
        }

        $Step = $myNewStartRight-$myLeft;

        $query="UPDATE Employees SET rgt = -rgt WHERE rgt > '{$myLeft}' AND rgt <= '{$myRight}'";
        $dbHandler->ExecuteQuery($query);
        $query="UPDATE Employees SET lft = -lft WHERE lft >= '{$myLeft}' AND lft < '{$myRight}'";
        $dbHandler->ExecuteQuery($query);

        $query="UPDATE Employees SET rgt = rgt - '{$myWidth}' WHERE rgt > '{$yLeft}'";
        $dbHandler->ExecuteQuery($query);
        $query="UPDATE Employees SET lft = lft - '{$myWidth}' WHERE lft > '{$myLeft}'";
        $dbHandler->ExecuteQuery($query);

        $query="UPDATE Employees SET rgt = rgt + '{$myWidth}' WHERE rgt >= '{$myNewStartRight}'";
        $dbHandler->ExecuteQuery($query);
        $query="UPDATE Employees SET lft = lft + '{$myWidth}' WHERE lft >= '{$myNewStartRight}'";
        $dbHandler->ExecuteQuery($query);

        $query="UPDATE Employees SET rgt = -rgt + '{$Step}' WHERE rgt <0";
        $dbHandler->ExecuteQuery($query);
        $query="UPDATE Employees SET lft = -lft + '{$Step}' WHERE lft <0";
        $dbHandler->ExecuteQuery($query);
        $dbHandler->dbDisconnect();
        unset($dbHandler);

       //$mysqli->multi_query($query);
       //$mysqli->close();
    }

if(isset($_POST['manager']))
{
    echo $_POST['user']."->".$_POST['manager'];
    MoveInHierarchy($_POST['user'], $_POST['manager']);
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
