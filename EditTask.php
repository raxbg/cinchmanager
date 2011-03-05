<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    $message="";
    if(isset($_POST['Add']))
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();

        $ProjectID=mysql_real_escape_string($_POST['ProjectID']);
        $Prioriry=mysql_real_escape_string($_POST['Prioriry']);
        $ShortDescription=mysql_real_escape_string($_POST['ShortDescription']);
        $Description=mysql_real_escape_string($_POST['Description']);
        $Visibility=mysql_real_escape_string($_POST['Visibility']);
        if ($_POST['Deadline']!='0000-00-00 00:00:00')
        {
            $Deadline="'".mysql_real_escape_string($_POST['Deadline'])."'";
        }
        else
        {
            $Deadline="NULL";
        }
        
        if($_POST['AssignedTo']!='noone')
        {
            $AssignedTo=mysql_real_escape_string($_POST['AssignedTo']);
        }
        else
        {
            $AssignedTo="NULL";
        }
        $query="INSERT INTO Tasks (ProjectID,UserID,ShortDescription,Description,Deadline,Priority,Visibility)
            VALUES({$ProjectID},{$AssignedTo},'{$ShortDescription}','{$Description}',$Deadline,$Prioriry,$Visibility)";
        
        if(!$dbHandler->ExecuteQuery($query))
        {
            $message.="<span class=\"NegativeMessage\">".COULD_NOT_CREATE_TASK_TEXT."</span>";
        }


        $dbHandler->dbDisconnect();
        unset($dbHandler);

    }
    if(isset($_POST['Edit']))
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();

        $TaskID=mysql_real_escape_string($_POST['TaskID']);
        $ProjectID=mysql_real_escape_string($_POST['ProjectID']);
        $Prioriry=mysql_real_escape_string($_POST['Prioriry']);
        $ShortDescription=mysql_real_escape_string($_POST['ShortDescription']);
        $Description=mysql_real_escape_string($_POST['Description']);
        $Visibility=mysql_real_escape_string($_POST['Visibility']);
        if ($_POST['Deadline']!='0000-00-00 00:00:00')
        {
            $Deadline="'".mysql_real_escape_string($_POST['Deadline'])."'";
        }
        else
        {
            $Deadline="NULL";
        }

        if($_POST['AssignedTo']!='noone')
        {
            $AssignedTo=mysql_real_escape_string($_POST['AssignedTo']);
        }
        else
        {
            $AssignedTo="NULL";
        }

        $query="UPDATE Tasks SET ProjectID={$ProjectID},UserID={$AssignedTo},ShortDescription='{$ShortDescription}',Description='{$Description}',
        Deadline=$Deadline,Priority=$Prioriry,Visibility=$Visibility
        WHERE ID = {$TaskID}";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $message.="<span class=\"NegativeMessage\">".COULD_NOT_UPDATE_TASK_TEXT."</span>";
        }


        $dbHandler->dbDisconnect();
        unset($dbHandler);

    }
    else
    {
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
                WHERE ProjectsAndMembers.UserID={$_SESSION['userinfo']['ID']}";
        $MembersQuery="SELECT ID, FirstName, LastName FROM Users";
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
                $Members = $dbHandler->MakeSelectOptions($MembersQuery, "ID", array("FirstName","LastName"), $UserID);
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
                $Members = $dbHandler->MakeSelectOptions($MembersQuery, "ID", array("FirstName","LastName"));
            }
        }
        else
        {
            $Projects = $dbHandler->MakeSelectOptions($ProjectsQuery, "ID", array("Name"));
            $Members = $dbHandler->MakeSelectOptions($MembersQuery, "ID", array("FirstName","LastName"));
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
?>
<form method="post">
    <?php echo PRIORITY_TEXT; ?><br />
    <select name="Prioriry">
        <option value="1" <?php if($Priority == "1"){ echo "selected=\"selected\"";} echo "/>".URGENT_TEXT; ?></option>
        <option value="2" <?php if($Priority == "2"){ echo "selected=\"selected\"";} echo "/>".HIGH_PRIORITY_TEXT; ?></option>
        <option value="3" <?php if($Priority == "3"){ echo "selected=\"selected\"";} echo "/>".NORMAL_PRIORITY_TEXT; ?></option>
        <option value="4" <?php if($Priority == "4"){ echo "selected=\"selected\"";} echo "/>".LOW_PRIORITY_TEXT; ?></option>
        <option value="5" <?php if($Priority == "5"){ echo "selected=\"selected\"";} echo "/>".LOWEST_PRIORITY_TEXT; ?></option>
    </select><br />
    <?php echo PROJECT_TEXT; ?><br />
    <select name="ProjectID">
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
    <select name="AssignedTo">
        <option value="noone"> </option>
        <?php echo $Members; ?>
    </select><br />
    <?php }else{ ?>
    <input type="hidden" name="Visibility" value="3" />
    <input type="hidden"name="AssignedTo" value="noone" />
    <?php } ?>
    <?php echo DEADLINE_TEXT; ?>
    <br />
    <input type="text" name="Deadline" value="<?php echo $Deadline; ?>" /><br />
    <?php if($Task){ ?>
    <input type="hidden"name="TaskID" value="<?php echo $TaskID; ?>" />
    <input type="submit" name="Edit" value="<?php echo EDIT_TEXT ?>" />
    <?php }else{ ?>
    <input type="submit" name="Add" value="<?php echo ADD_TEXT ?>" />
    <?php } ?>
</form>

<?php
        }
    }
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
