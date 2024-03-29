<?php

class Hierarchy
{
    public static function AddToHierarchy($managerID,$userID,$position,$canCreateAccounts,$isAdmin,$assignmentDay,$salary)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $dbHandler->ExecuteQuery("BEGIN");

        $managerID=mysql_real_escape_string($managerID);
        $userID=mysql_real_escape_string($userID);
        $position=mysql_real_escape_string($position);
        $canCreateAccounts=mysql_real_escape_string($canCreateAccounts);
        $isAdmin=mysql_real_escape_string($isAdmin);
        $assignmentDay=mysql_real_escape_string($assignmentDay);
        $salary=mysql_real_escape_string($salary);
        if($managerID != "none")
        {
            $myLeftResult = $dbHandler->ExecuteQuery("SELECT lft FROM Employees WHERE UserID = {$managerID}");
            $myLeft=mysql_fetch_row($myLeftResult);
            $myLeft = $myLeft[0];
        }
        else
        {
            $myLeftResult = $dbHandler->ExecuteQuery("SELECT MAX(rgt) FROM Employees");
            $myLeft=mysql_fetch_row($myLeftResult);
            $myLeft = $myLeft[0];
            if ($myLeft==NULL)
            {
                $myLeft=0;
            }
        }
        $query="INSERT INTO Salaries (UserID, FromDate, Amount)
                Values ('{$userID}','{$assignmentDay}','{$salary}')";
        if (!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        if (!$dbHandler->ExecuteQuery("UPDATE Employees SET rgt = rgt + 2 WHERE rgt > {$myLeft}"))
        {
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        if (!$dbHandler->ExecuteQuery("UPDATE Employees SET lft = lft + 2 WHERE lft > {$myLeft}"))
        {
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="INSERT INTO Employees(UserID, PositionID, CanCreateAccounts,IsAdmin, AssignmentDay, lft, rgt)
            VALUES('{$userID}', '{$position}','{$canCreateAccounts}', '{$isAdmin}','{$assignmentDay}', {$myLeft} + 1, {$myLeft} + 2)";
        if (!$dbHandler->ExecuteQuery($query))
        {
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $dbHandler->ExecuteQuery("COMMIT");
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        return true;
    }

    public static function IsXManagerOfY($Employee,$Manager)
    {
        if($Employee==$Manager)
        {
            return false;
        }
        
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $employee=mysql_real_escape_string($Employee);
        $query="SELECT parent.UserID
            FROM Employees AS node,
            Employees AS parent
            WHERE node.lft BETWEEN parent.lft AND parent.rgt
            AND node.UserID='{$employee}'
            ORDER BY parent.lft";

        $result=$dbHandler->ExecuteQuery($query);
        while($manager=mysql_fetch_row($result))
        {
            if($manager[0]==$Manager)
            {
                $dbHandler->dbDisconnect();
                unset($dbHandler);
                return true;
            }
        }
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        return false;
    }

    public static static function MoveInHierarchy($user,$toManager)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $user = mysql_real_escape_string($user);
        $toManager = mysql_real_escape_string($toManager);
        $dbHandler->ExecuteQuery("BEGIN");

        $query="SELECT @myRight := rgt,@myLeft := lft ,@myWidth:=rgt-lft+1 FROM Employees WHERE UserID='{$user}'";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = -rgt WHERE rgt > @myLeft AND rgt <= @myRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = -lft WHERE lft >= @myLeft AND lft < @myRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = rgt - @myWidth WHERE rgt > @myLeft";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = lft - @myWidth WHERE lft > @myLeft";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        if($toManager == "none")
        {
            $query="SELECT @myNewStartRight := MAX(rgt)+1 FROM Employees";
        }
        else
        {
            $query="SELECT @myNewStartRight := rgt FROM Employees WHERE UserID={$toManager}";
        }
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="SELECT @Step := @myNewStartRight-@myLeft;";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = rgt + @myWidth WHERE rgt >= @myNewStartRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        };
        $query="UPDATE Employees SET lft = lft + @myWidth WHERE lft >= @myNewStartRight";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }

        $query="UPDATE Employees SET rgt = -rgt + @Step WHERE rgt <0";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $query="UPDATE Employees SET lft = -lft + @Step WHERE lft <0";
        if(!$dbHandler->ExecuteQuery($query))
        {
            echo mysql_error();
            $dbHandler->ExecuteQuery("ROLLBACK");
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            return false;
        }
        $dbHandler->ExecuteQuery("COMMIT");
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        return true;
    }
    public static function Dismiss($Employee)
    {
        if(self::MoveInHierarchy($Employee, "none"))
        {
            $dbHandler=new dbHandler();
            $dbHandler->dbConnect();
            $UserID=mysql_real_escape_string($Employee);
            $query="UPDATE Employees
            SET lft=NULL, rgt=NULL,EndDate='".date("Y-m-d")."'
            WHERE UserID={$UserID}";
            if($dbHandler->ExecuteQuery($query))
            {
                return true;
            }
            else
            {
                return false;
            }
            $dbHandler->dbDisconnect();
            unset($dbHandler);
        }
        else
        {
            return false;
        }
    }
    public static function FindManager($Employee)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $UserId = mysql_real_escape_string($Employee);
        $query="SELECT parent.UserID
            FROM Employees AS node,
            Employees AS parent
            WHERE node.lft BETWEEN parent.lft AND parent.rgt
            AND node.UserID = {$UserId}
            ORDER BY parent.lft DESC";
        $result = $dbHandler->ExecuteQuery($query);
        mysql_fetch_row($result);
        $manager = mysql_fetch_row($result);
        if($manager)
        {
            return $manager[0];
        }
        else
        {
            return null;
        }
    }
}
?>
