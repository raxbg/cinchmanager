<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['IsAdmin'] == true)
{
    $message="";
    if(isset($_POST['Add']))
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $ProjectID=mysql_real_escape_string($_POST['ProjectID']);
        $UserID=mysql_real_escape_string($_POST['UserID']);
        if(isset($_POST['IsLeader']))
        {
            $IsLeader=1;
        }
        else
        {
            $IsLeader=0;
        }
        if (isset($_POST['IsOwner']))
        {
            $IsOwner=1;
        }
        else
        {
            $IsOwner=0;
        }
        $query="INSERT INTO ProjectsAndMembers (UserID,ProjectID,IsLeader,IsOwner)
            VALUES('{$UserID}','{$ProjectID}','{$IsLeader}','{$IsOwner}')";
        $dbHandler->ExecuteQuery($query);
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        $message="<span class=\"PositiveMessage\">".MEMBER_ADDED_TEXT."</span>";
    }

    if(isset($_GET['id']))
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id=mysql_real_escape_string($_GET['id']);
        $query = "SELECT Name FROM Projects WHERE ID={$id}";
        $project = $dbHandler->ExecuteQuery($query);
        $ProjectName=mysql_fetch_row($project);
        $ProjectName = $ProjectName[0];
        if($ProjectName!=null&&$ProjectName!="") //taq proverka ne mi haresva, iskam da proverqvam dali querito vry6ta rezultat
        {
            $usersQuery = "SELECT ID, FirstName, LastName From Users ORDER BY FirstName, LastName";
            $users = $dbHandler->MakeSelectOptions($usersQuery, "ID", array("FirstName","LastName"));

            $query="SELECT Users.ID, Users.FirstName, Users.LastName, ProjectsAndMembers.IsLeader,ProjectsAndMembers.IsOwner FROM ProjectsAndMembers
                    LEFT JOIN Users ON Users.ID = ProjectsAndMembers.UserID
                    WHERE ProjectID = {$id}";
            $members = $dbHandler->ExecuteQuery($query);
            $MembersList="";
            while($member = mysql_fetch_array($members))
            {
                $MembersList.="<li><b>{$member['FirstName']} {$member['LastName']}</b>";
                if($member['IsOwner'])
                {
                    $MembersList.=" (".PROJECT_OWNER_TEXT.")";
                }
                if($member['IsLeader'])
                {
                    $MembersList.=" (".PROJECT_LEADER_TEXT.")";
                }
                $MembersList.="</li>\n";
            }

            $dbHandler->dbDisconnect();
            unset($dbHandler);

            echo "<h1>".MEMBERS_OF_TEXT." ".$ProjectName."</h1>";
            echo $message;
            if ($MembersList=="")
            {
                echo "<span class=\"NegativeMessage\">".NO_MEMBERS_TEXT."</span>";
            }
            else
            {
                echo
                "<ul class=\"MembersOfProject\">\n".
                $MembersList.
                "</ul>";

            }
?>
            <form method="post">
                <h2><?php echo ADD_NEW_MEMBER_TEXT; ?></h2>
                <input type="hidden" name="ProjectID" value="<?php echo $_GET['id']; ?>">
                <select name="UserID">
                    <?php echo $users;?>
                </select><br />
                <input type="checkbox" name="IsOwner" value="Owner" />
                <?php echo PROJECT_OWNER_TEXT;?><br />
                <input type="checkbox" name="IsLeader" value="Leader" />
                <?php echo PROJECT_LEADER_TEXT;?><br />
                <input type="submit" name="Add" value="<?php echo ADD_TEXT; ?>">
            </form>
<?php
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