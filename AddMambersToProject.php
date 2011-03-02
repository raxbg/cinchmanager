<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['IsAdmin'] == true)
{
    if(isset($_POST['Add']))
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $ProjectID=mysql_real_escape_string($_POST['ProjectID']);
        $UserID=mysql_real_escape_string($_POST['UserID']);
        //query
    }
    elseif(isset($_GET['id']))
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
            $dbHandler->dbDisconnect();
            unset($dbHandler);

?>
            <h1><?php echo MEMBERS_OF_TEXT." ".$ProjectName; ?></h1>
            <form method="post">
                <h3><?php echo ADD_NEW_MEMBER_TEXT; ?></h3>
                <input type="hidden" name="ProjectID" value="<?php echo $_GET['id']; ?>">
                <select name="UserID">
                    <?php echo $users;?>
                </select><br />
                <input type="checkbox" name="Owner" value="Owner" />
                <?php echo PROJECT_OWNER_TEXT;?><br />
                <input type="checkbox" name="Leader" value="Leader" />
                <?php echo PROJECT_LEADER_TEXT;?><br />
                <input type="submit" name="Add" value="<?php echo ADD_TEXT; ?>">
            </form>
<?php
        }
        else
        {
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