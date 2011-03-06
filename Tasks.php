<?php
if(isset($_SESSION['LoggedIn']))
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();

    if(isset($_POST['EditTaskStatus']))
    {
        $taskId = mysql_real_escape_string($_POST['TaskID']);
        $status = mysql_real_escape_string($_POST['NewStatus']);
        $query="UPDATE Tasks SET Status={$status} WHERE ID={$taskId}";
        if($dbHandler->ExecuteQuery($query))
        {
            $message.="<span class=\"PositiveMessage\">".TASK_UPDATED_TEXT."</span>";
        }
        else
        {
            $message.="<span class=\"NegativeMessage\">".COULD_NOT_UPDATE_TASK_TEXT."</span>";
        }
    }
    elseif(isset($_POST['AddTask']))
    {
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

        echo "<span class=\"PositiveMessage\">".TASK_ADDED_TEXT."</span>";

    }
    elseif(isset($_POST['EditTask']))
    {
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
        else
        {
            $message.= "<span class=\"PositiveMessage\">".TASK_UPDATED_TEXT."</span>";
        }

    }

    if($_SESSION['userinfo']['IsAdmin'] == true)
    {
        $query="SELECT ID, Name FROM Projects";

    }
    else
    {
        $id=mysql_real_escape_string($_SESSION['userinfo']['ID']);
        $query="SELECT Projects.ID, Projects.Name FROM ProjectsAndMembers
                LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
                Where UserID={$id}";
    }

    $Tasks="";
    $UserID = mysql_real_escape_string($_SESSION['userinfo']['ID']);
    if(isset($_GET['Project']) && $_GET['Project']!="" && $_GET['Project']!="all" && is_numeric($_GET['Project']))
    {
        $ProjectID = mysql_real_escape_string($_GET['Project']);
        $Projects=$dbHandler->MakeSelectOptions($query, "ID", array("Name"),$ProjectID);
        $query="SELECT Tasks.ID, Tasks.Priority, Projects.Name AS Project, Tasks.ShortDescription, Tasks.Deadline,
            Tasks.Status, Tasks.UserID, Tasks.Visibility, ProjectsAndMembers.IsLeader AS UserIsLeader
            FROM ProjectsAndMembers
            LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
            LEFT JOIN Tasks ON Tasks.ProjectID = ProjectsAndMembers.ProjectID
            WHERE ProjectsAndMembers.UserID = {$UserID} AND Projects.ID={$ProjectID}
            ORDER BY Tasks.Deadline DESC, Tasks.Priority ASC, Project ASC, Tasks.AssignmentTime ASC";
    }
    else
    {
        $Projects=$dbHandler->MakeSelectOptions($query, "ID", array("Name"));
        $query="SELECT Tasks.ID, Tasks.Priority, Projects.Name AS Project, Tasks.ShortDescription, Tasks.Deadline,
            Tasks.Status, Tasks.UserID, Tasks.Visibility, ProjectsAndMembers.IsLeader AS UserIsLeader
            FROM ProjectsAndMembers
            LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
            LEFT JOIN Tasks ON Tasks.ProjectID = ProjectsAndMembers.ProjectID
            WHERE ProjectsAndMembers.UserID = {$UserID} AND Tasks.Status<100
            ORDER BY Tasks.Deadline DESC, Tasks.Priority ASC, Project ASC, Tasks.AssignmentTime ASC";
    }

    $result = $dbHandler->ExecuteQuery($query);
    if(mysql_num_rows($result)>0)
    {
        $isTableEmpty = false;
        while($Task = mysql_fetch_array($result))
        {
            if ($i%2==0)
            {
                $class="class=\"odd ActiveField\"";
            }
            else
            {
                $class="class=\"even ActiveField\"";
            }
            $i++;

            if((($Task['Visibility']==1)&&($Task['UserID']==$_SESSION['userinfo']['ID']))||
                    (($Task['Visibility']==2)&&($_SESSION['userinfo']['EmployeeOrClient']=='e'))||
                    ($Task['Visibility']==3)||
                    ($Task['UserIsLeader']))
            {
            $Tasks.="<tr {$class} onClick=\"PopUpBox('./Task.php?id={$Task['ID']}');LoadStatus({$Task['ID']})\">".
                        "<td>{$Task['Project']}</td>\n".
                        "<td>{$Task['ShortDescription']}</td>\n".
                        "<td>{$Task['Deadline']}</td>\n".
                        "<td>{$Task['Status']}%</td>\n".
                        "</tr>";
            }
        }
    }
    else
    {
        $isTableEmpty = true;
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);
    echo $message;
?>
<script type="text/javascript" src="js/Ajax.js"></script>
<h1><?php echo TASKS_TEXT; ?></h1>
<form method="get" id="SelectProject">
    <?php echo PROJECT_TEXT;?>
    <input type="hidden" name="page" value="Tasks" />
    <select name="Project" onchange="document.getElementById('SelectProject').submit()">
        <option value="all"><?php echo ALL_TEXT;?></option>
        <?php echo $Projects; ?>
    </select>
</form>
<?php if(!$isTableEmpty)
{?>
<table class="cooltable">
    <thead class="cooltable">
        <tr>
            <td><?php echo PROJECT_NAME1_TEXT; ?></td>
            <td><?php echo SHORT_DESCRIPTION1_TEXT; ?></td>
            <td width="132"><?php echo DEADLINE1_TEXT; ?></td>
            <td width="60"><?php echo STATUS_TEXT; ?></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $Tasks; ?>
    </tbody>
</table>
<?php }?>
<span class="ActiveField" onClick="PopUpBox('./EditTask.php')"><?php echo ADD_TASK_TEXT; ?></span>
<?php
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
