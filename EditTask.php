<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();

    $Projects="";
    $Priority=3;
    $ShortDescription="";
    $Description="";
    $Visibility=3;
    $Deadline="0000-00-00 00:00:00";
    $ProjectsQuery="SELECT Projects.ID, Projects.Name From ProjectsAndMembers
            LEFT JOIN Projects ON ProjectsAndMembers.ProjectID = Projects.ID
            WHERE ProjectsAndMembers.UserID={$_SESSION['userinfo']['ID']}
            ORDER BY Projects.ID ASC";
    if(isset($_GET['id'])&&$_GET['id']!="")
    {
        $TaskID=mysql_real_escape_string($_GET['id']);
        $TaskQuery="SELECT * FROM Tasks Where ID = {$TaskID}";
        $TaskResult=$dbHandler->ExecuteQuery($TaskQuery);
        $Task=mysql_fetch_array($TaskResult);
        if($Task)
        {
            $Priority=$Task['Priority'];
            $ShortDescription=$Task['ShortDescription'];
            $Description=$Task['Description'];
            $Visibility=$Task['Visibility'];
            $ProjectID=mysql_real_escape_string($Task['ProjectID']);
            $UserID = mysql_real_escape_string($Task['UserID']);
            $Projects = $dbHandler->MakeSelectOptions($ProjectsQuery, "ID", array("Name"), $ProjectID);
            $query = "SELECT Users.ID,Users.FirstName,Users.LastName
                        FROM ProjectsAndMembers
                        LEFT JOIN Users
                        ON ProjectsAndMembers.UserID = Users.ID
                        WHERE ProjectsAndMembers.ProjectID={$ProjectID}";
            $MembersLis = "<option value=\"noone\"> </option>";
            $MembersLis.= $dbHandler->MakeSelectOptions($query, "ID", array("FirstName","LastName"),$Task['UserID']);
            if($Task['Deadline'])
            {
                $Deadline=$Task['Deadline'];
            }
            else
            {
                $Deadline="0000-00-00 00:00:00";
            }
        }
        else
        {
            $message.="<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
            $Projects = $dbHandler->MakeSelectOptions($ProjectsQuery, "ID", array("Name"));
            $result = $dbHandler->ExecuteQuery("SELECT MIN( ID ) FROM Projects");
            $FirsProjectId = mysql_fetch_row($result);
            $FirsProjectId = $FirsProjectId[0];
            $query = "SELECT Users.ID,Users.FirstName,Users.LastName
                        FROM ProjectsAndMembers
                        LEFT JOIN Users
                        ON ProjectsAndMembers.UserID = Users.ID
                        WHERE ProjectsAndMembers.ProjectID={$FirsProjectId}";
            $MembersLis = "<option value=\"noone\"> </option>";
            $MembersLis.= $dbHandler->MakeSelectOptions($query, "ID", array("FirstName","LastName"));
        }
    }
    else
    {
        $Projects = $dbHandler->MakeSelectOptions($ProjectsQuery, "ID", array("Name"));
        $result = $dbHandler->ExecuteQuery("SELECT MIN( ID ) FROM Projects");
        $FirsProjectId = mysql_fetch_row($result);
        $FirsProjectId = $FirsProjectId[0];
        $query = "SELECT Users.ID,Users.FirstName,Users.LastName
                    FROM ProjectsAndMembers
                    LEFT JOIN Users
                    ON ProjectsAndMembers.UserID = Users.ID
                    WHERE ProjectsAndMembers.ProjectID={$FirsProjectId}";
        $MembersLis = "<option value=\"noone\"> </option>";
        $MembersLis.= $dbHandler->MakeSelectOptions($query, "ID", array("FirstName","LastName"));
    }

    if($Projects == "")
    {
        echo "<span class=\"NegativeMessage\">".NOT_MEMBER_OF_ANY_PROJECT_TEXT."</span>";
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        echo $message;
?>
<script type="text/javascript" src="js/Ajax.js"></script>
<form method="post" action="index.php?page=Tasks">
    <?php echo PRIORITY_TEXT; ?><br />
    <select name="Prioriry">
        <option value="1" <?php if($Priority == "1"){ echo "selected=\"selected\"";} echo "/>".URGENT_TEXT; ?></option>
        <option value="2" <?php if($Priority == "2"){ echo "selected=\"selected\"";} echo "/>".HIGH_PRIORITY_TEXT; ?></option>
        <option value="3" <?php if($Priority == "3"){ echo "selected=\"selected\"";} echo "/>".NORMAL_PRIORITY_TEXT; ?></option>
        <option value="4" <?php if($Priority == "4"){ echo "selected=\"selected\"";} echo "/>".LOW_PRIORITY_TEXT; ?></option>
        <option value="5" <?php if($Priority == "5"){ echo "selected=\"selected\"";} echo "/>".LOWEST_PRIORITY_TEXT; ?></option>
    </select><br />
    <?php echo PROJECT_TEXT; ?><br />
    <select name="ProjectID" id="ProjectID" onchange="FillMembers()">
        <?php echo $Projects; ?>
    </select><br />
    <?php echo SHORT_DESCRIPTION_TEXT; ?><br />
    <input type="text" name="ShortDescription" value="<?php echo $ShortDescription; ?>" /><br />
    <?php echo DESCRIPTION_TEXT; ?><br />
    <textarea name="Description"><?php echo $Description; ?></textarea><br />
    <?php if($_SESSION['userinfo']['EmployeeOrClient']=='e') { ?>
    <?php echo VISIBILITY_TEXT; ?>
    <br />
    <input type="radio" name="Visibility" value="1" <?php if($Visibility == "1"){ echo "checked=\"checked\"";} echo "/>".PRIVATE_TEXT; ?>
    <input type="radio" name="Visibility" value="2" <?php if($Visibility == "2"){ echo "checked=\"checked\"";} echo "/>".INTERNAL_TEXT; ?>
    <input type="radio" name="Visibility" value="3" <?php if($Visibility == "3"){ echo "checked=\"checked\"";} echo "/>".EVERYONE_TEXT; ?><br />
    <?php echo ASSIGN_TO_TEXT; ?><br />
    <select name="AssignedTo" id="ProjectMembers">
        <?php echo $MembersLis; ?>
    </select><br />
    <script type="text/javascript">
        FillMembers();
    </script>
    <?php }else{ ?>
    <input type="hidden" name="Visibility" value="3" />
    <input type="hidden"name="AssignedTo" value="noone" />
    <?php } ?>
    <?php echo DEADLINE_TEXT; ?>
    <br />
    <input type="text" name="Deadline" value="<?php echo $Deadline; ?>" /><br />
    <?php if($Task){ ?>
    <input type="hidden"name="TaskID" value="<?php echo $TaskID; ?>" />
    <input type="submit" name="EditTask" value="<?php echo EDIT_TEXT ?>" />
    <?php }else{ ?>
    <input type="submit" name="AddTask" value="<?php echo ADD_TEXT ?>" />
    <?php } ?>
</form>

<?php
    }
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
