<?php
if(isset($_SESSION['LoggedIn']))
{
    $Projects="";
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    if($_SESSION['userinfo']['IsAdmin'] == true)
    {
        $query="SELECT ID, Name, StartDate, Status FROM Projects";
        
    }
    else
    {
        $id=mysql_real_escape_string($_SESSION['userinfo']['ID']);
        $query="SELECT Projects.ID, Projects.Name, ProjectsAndMembers.IsOwner, ProjectsAndMembers.IsLeader,
                Projects.StartDate, Projects.Status FROM ProjectsAndMembers
                LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
                Where UserID={$id}";
    }
    $result = $dbHandler->ExecuteQuery($query);
    while($project = mysql_fetch_array($result))
    {
        switch($project['Status'])
        {
            case 1:
                $status=IN_PROGRESS_TEXT;
                break;
            case 2:
                $status=HALT_TEXT;
                break;
            case 3:
                $status=FINNISHED_TEXT;
                break;
            case 4:
                $status=CANCELED_TEXT;
                break;
            default:
                $status="";
                break;
        }
        if ($i%2==0)
        {
            $class="class=\"odd\"";
        }
        else
        {
            $class="class=\"even\"";
        }
        $i++;

        $Projects.="<tr {$class} onClick=\"PopUpBox('./Project.php?id={$project['ID']}')\">".
                    "<td>{$project['Name']}</td>\n".
                    "<td>{$project['StartDate']}</td>\n".
                    "<td>{$status}</td>\n";
        if($_SESSION['userinfo']['IsAdmin'])
        {
            $Projects .= "<td class=\"editBtn\"><a href=\"index.php?page=EditProject&id={$project['ID']}\"><img src=\"img/edit.gif\"></a></td>\n";
        }
        $Projects .= "</tr>";
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);

?>
<h1><?php echo PROJECTS_TEXT; ?></h1>
<table class="cooltable">
    <thead>
        <tr>
            <td><?php echo PROJECT_NAME1_TEXT; ?></td>
            <td><?php echo START_DATE_TEXT; ?></td>
            <td><?php echo STATUS_TEXT; ?></td>
<?php
            if($_SESSION['userinfo']['IsAdmin'])
            {
                echo "<td>".EDIT_TEXT."</td>";
            }
?>
        </tr>
    </thead>
    <tbody>
        <?php echo $Projects; ?>
    </tbody>
</table>
<?php
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>
