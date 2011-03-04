<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['ProjectId'])&&$_GET['ProjectId']!="")
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $ProjectId=mysql_real_escape_string($_GET['ProjectId']);
        $query = "SELECT * FROM Projects WHERE Projects.ID='{$ProjectId}'";
        $result = $dbHandler->ExecuteQuery($query);
        if(mysql_num_rows($result)>0)
        {
            $Project=mysql_fetch_array($result);
            $query = "SELECT ProjectsAndMembers.UserID, Employees.lft, Employees.rgt
                        FROM ProjectsAndMembers
                        LEFT JOIN Employees ON Employees.UserID = ProjectsAndMembers.UserID
                        WHERE ProjectsAndMembers.ProjectID ='{$ProjectId}'";
            $result = $dbHandler->ExecuteQuery($query);
            $isMember=false;
            while($member=  mysql_fetch_array($result))
            {
                if(($member['UserID']==$_SESSION['userinfo']['ID'])||(($member['lft']>$_SESSION['userinfo']['lft'])&&($member['rgt']<$_SESSION['userinfo']['rgt'])))
                {
                    $isMember=true;
                }
            }
            if($isMember)
            {
                //tuk trqbva da se sloji i uslovieto za TaskId
                echo "Там си";
                $dbHandler->dbDisconnect();
                unset($dbHandler);
?>


<?php
            }
            else
            {
                echo "<span class=\"NegativeMessage\">".NOT_MEMBER_TEXT."</span>";
                $dbHandler->dbDisconnect();
                unset($dbHandler);
            }
        }
        else
        {
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            echo "<span class=\"NegativeMessage\">".PROJECT_NOT_FOUND_TEXT."</span>";
        }
    }
    else
    {
        echo "<span class=\"NegativeMessage\">".PROJECT_NOT_FOUND_TEXT."</span>";
    }
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";;
}
?>
