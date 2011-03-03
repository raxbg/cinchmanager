<?php
function MoveInHierarchy($user,$toManager)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $user = mysql_real_escape_string($user);
        $toManager = mysql_real_escape_string($toManager);
        $dbHandler->ExecuteQuery("BEGIN");

        $query="SELECT @myRight := rgt,@myLeft := lft ,@myWidth:=rgt-lft+1 FROM Employees WHERE UserID='{$user}'";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="SELECT @myNewLeft := lft, @myNewRight := rgt FROM Employees WHERE UserID='{$toManager}'";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = -rgt WHERE rgt > @myLeft AND rgt <= @myRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = -lft WHERE lft >= @myLeft AND lft < @myRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = rgt - @myWidth WHERE rgt > @myLeft";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = lft - @myWidth WHERE lft > @myLeft";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="SELECT @myNewStartRight := rgt FROM Employees WHERE UserID='{$toManager}'";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="SELECT @Step := @myNewStartRight-@myLeft;";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = rgt + @myWidth WHERE rgt >= @myNewStartRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        };
        $query="UPDATE Employees SET lft = lft + @myWidth WHERE lft >= @myNewStartRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = -rgt + @Step WHERE rgt <0";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = -lft + @Step WHERE lft <0";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $dbHandler->ExecuteQuery("COMMIT");
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        return true;
    }

if(isset($_POST['manager']))
{
    if(MoveInHierarchy($_POST['user'], $_POST['manager']))
    {
        echo "User group successfully moved";
    }
    else
    {
        echo "Failed to move user group";
    }
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
    Give:<select name="user"><?php echo $users;?></select><br />
    To:<select name="manager"><?php echo $users;?></select><br />
    <input type="submit" value="Move">
</form>
<?php
}

?>
