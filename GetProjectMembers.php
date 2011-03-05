<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']) && isset($_GET['id']) && $_GET['id'] != "")
{
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $options="\n";
    $projectId = mysql_real_escape_string($_GET['id']);
    $query = "SELECT Users.ID,Users.FirstName,Users.LastName
        FROM ProjectsAndMembers
        LEFT JOIN Users
        ON ProjectsAndMembers.UserID = Users.ID
        WHERE ProjectsAndMembers.ProjectID={$projectId}";
    $options = $dbHandler->MakeSelectOptions($query, "ID", array("FirstName","LastName"));
    $dbHandler->dbDisconnect();
    unset($dbHandler);
    echo $options;
}
elseif(!isset($_GET['id']))
{
    echo "<span class=\"NegativeMessage\">";
    echo MISSING_PARAMETER_TEXT;
    echo "</span>";
}
elseif($_GET['id'] != "")
{
    echo "<span class=\"NegativeMessage\">";
    echo MISSING_PARAMETER_TEXT;
    echo "</span>";
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo "<span class=\"NegativeMessage\">";
    echo PLEASE_LOGIN_TEXT;
    echo "</span>";
}
?>
