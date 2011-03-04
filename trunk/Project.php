<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['EmployeeOrClient'] == "e")
{
    if(isset($_GET['id']))
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id=mysql_real_escape_string($_GET['id']);
        $query = "SELECT * FROM Projects WHERE ID={$id}";
        $result = $dbHandler->ExecuteQuery($query);
        if(mysql_num_rows($result)>0)
        {
            $Project = mysql_fetch_array($result);
            switch($Project['Status'])
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

            $query="SELECT Users.ID, Users.FirstName, Users.LastName, ProjectsAndMembers.IsLeader,ProjectsAndMembers.IsOwner FROM ProjectsAndMembers
                    LEFT JOIN Users ON Users.ID = ProjectsAndMembers.UserID
                    WHERE ProjectID = {$id}";
            $members = $dbHandler->ExecuteQuery($query);
            $MembersList="";
            while($member = mysql_fetch_array($members))
            {
                $MembersList.="<li onClick=\"PopUpBox('./UserInfo.php?id={$member['ID']}')\" ><b>{$member['FirstName']} {$member['LastName']}</b>";
                if($member['IsOwner'])
                {
                    $MembersList.=" (".PROJECT_OWNER_TEXT.")";
                }
                if($member['IsLeader'])
                {
                    $MembersList.=" (".PROJECT_LEADER_TEXT.")";
                }
                $MembersList.="</li>";
            }
            $dbHandler->dbDisconnect();
            unset($dbHandler);
?>
            <h1><?php echo $Project['Name']." (".$status.")";?></h1>
            <div id="ProjectDescription"><?php echo $Project['Description'];?></div>
            <hr />
<?php       if($MembersList!="")
            {
?>
            <h3><?php echo MEMBERS_TEXT; ?></h3>
            <ul>
                <?php echo $MembersList; ?>
            </ul>
<?php
            }
            if($_SESSION['userinfo']['IsAdmin'])
            {
                echo "<a href=\"index.php?page=MembersOfProject&id={$Project['ID']}\">".ADD_MEMBERS_TEXT."</a><br />\n".
                    "<a href=\"index.php?page=EditProject&id={$Project['ID']}\">".EDIT_PROJECT_TEXT."</a>";
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
elseif(isset($_SESSION['LoggedIn']))
{
    echo NOT_ALLOWED_TO_EDIT_PROJECTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>
