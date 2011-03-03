<?php

class Hierarchy
{
    public function AddToHierarchy($managerID,$userID,$position,$canCreateAccounts,$isAdmin,$assignmentDay,$salary)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();

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
        }
        $query="INSERT INTO Salaries (UserID, FromDate, Amount)
                Values ('{$userID}','{$assignmentDay}','{$salary}')";
        $dbHandler->ExecuteQuery($query);
        $dbHandler->ExecuteQuery("UPDATE Employees SET rgt = rgt + 2 WHERE rgt > {$myLeft}");
        $dbHandler->ExecuteQuery("UPDATE Employees SET lft = lft + 2 WHERE lft > {$myLeft}");
        $query="INSERT INTO Employees(UserID, PositionID, CanCreateAccounts,IsAdmin, AssignmentDay, lft, rgt)
            VALUES('{$userID}', '{$position}','{$canCreateAccounts}', '{$isAdmin}','{$assignmentDay}', {$myLeft} + 1, {$myLeft} + 2)";
        if ($dbHandler->ExecuteQuery($query))
        {
            return true;
        }
        else
        {
            return false;
        }
        $dbHandler->dbDisconnect();
    }

    public static function MoveInHierarchy($user,$toManager)
    {
        //stavat anomalii, raboti si kakto trqbva no ne prorabotva vinagi,
        //sqkash trqbva da mine opredeleno vreme sled poslednoto polzvane
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
        $user = $mysqli->real_escape_string($user);
        $toManager = $mysqli->real_escape_string($toManager);
        echo $user."->".$toManager;
        $query="SELECT @myRight := rgt,@myLeft := lft ,@myWidth:=rgt-lft+1 FROM Employees WHERE UserID='{$user}';

            SELECT @myNewLeft := lft, @myNewRight := rgt FROM Employees
            WHERE UserID='{$toManager}';

            UPDATE Employees SET rgt = -rgt WHERE rgt > @myLeft AND rgt <= @myRight;
            UPDATE Employees SET lft = -lft WHERE lft >= @myLeft AND lft < @myRight;

            UPDATE Employees SET rgt = rgt - @myWidth WHERE rgt > @myLeft;
            UPDATE Employees SET lft = lft - @myWidth WHERE lft > @myLeft;

            SELECT @myNewStartRight := rgt FROM Employees WHERE UserID='{$toManager}';
            SELECT @Step := @myNewStartRight-@myLeft;

            UPDATE Employees SET rgt = rgt + @myWidth WHERE rgt >= @myNewStartRight;
            UPDATE Employees SET lft = lft + @myWidth WHERE lft >= @myNewStartRight;

            UPDATE Employees SET rgt = -rgt + @Step WHERE rgt <0;
            UPDATE Employees SET lft = -lft + @Step WHERE lft <0;";
       if(!$mysqli->multi_query($query)) die("Error: ".$mysqli->error);
       $mysqli->close();
    }

    public function IsXManagerOfY($Employee,$Manager)
    {
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
                return true;
            }
        }
        $dbHandler->dbDisconnect();
        return false;
    }
}
?>
