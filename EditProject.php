<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['IsAdmin'] == true)
{
    if(isset($_POST['Add'])&&isset($_POST['ProjectName'])&&$_POST['ProjectName']!="")
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $branch=mysql_real_escape_string($_POST['BranchID']);
        $name=mysql_real_escape_string($_POST['ProjectName']);
        $description=mysql_real_escape_string($_POST['Description']);
        $date=mysql_real_escape_string(date("Y-m-d"));
        $query="INSERT INTO Projects (BranchID,Name,StartDate,Status,Description)
            VALUES('{$branch}','{$name}','{$date}','1','{$description}')";
        $dbHandler->ExecuteQuery($query);
        echo mysql_error();
        $query = "SELECT ID FROM Projects WHERE Name = '{$name}'";
        $result = $dbHandler->ExecuteQuery($query);
        $id=mysql_fetch_row($result);
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        echo "<span class=\"PositiveMessage\">".PROJECT_ADDED_TEXT."</span>";
        echo "<a href=\"index.php?page=MembersOfProject&id={$id[0]}\">".ADD_MEMBERS_TEXT."</a>";

    }
    elseif(isset($_POST['Edit'])&&isset($_POST['ProjectName'])&&$_POST['ProjectName']!="")
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $branch=mysql_real_escape_string($_POST['BranchID']);
        $name=mysql_real_escape_string($_POST['ProjectName']);
        $description=mysql_real_escape_string($_POST['Description']);
        $id=mysql_real_escape_string($_POST['ID']);
        $query="UPDATE Projects SET BranchID='{$branch}',
            Name='{$name}', Description='{$description}'
            WHERE Projects.ID='{$id}'";
        $dbHandler->ExecuteQuery($query);
        echo mysql_error();
        $query = "SELECT ID FROM Projects WHERE Name = '{$name}'";
        $result = $dbHandler->ExecuteQuery($query);
        $id=mysql_fetch_row($result);
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        echo "<span class=\"PositiveMessage\">".PROJECT_UPDATED_TEXT."</span>";
        echo "<a href=\"index.php?page=MembersOfProject&id={$id[0]}\">".ADD_MEMBERS_TEXT."</a>";
    }
    else
    {

        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        if(isset($_POST['Add'])||isset($_POST['Edit']))
        {
            $name="";
            $branches = $dbHandler->MakeSelectOptions("SELECT ID,Name FROM Branches", "ID", array("Name"),$_POST['BranchID']);
            $description=$_POST['Description'];
            $message = "<span class=\"NegativeMessage\">".ENTER_PROJECT_NAME_TEXT."</span>";
        }
        elseif(isset($_GET['id'])&&$_GET['id']!="")
        {
            $dbHandler = new dbHandler();
            $dbHandler->dbConnect();
            $id=mysql_real_escape_string($_GET['id']);
            $query = "SELECT * FROM Projects WHERE ID = '{$id}'";
            $result = $dbHandler->ExecuteQuery($query);
            $project=mysql_fetch_array($result);
            $name=$project['Name'];
            $branches = $dbHandler->MakeSelectOptions("SELECT ID,Name FROM Branches", "ID", array("Name"),$project['BranchID']);
            $description=$project['Description'];
        }
        else
        {
            $name="";
            $branches = $dbHandler->MakeSelectOptions("SELECT ID,Name FROM Branches", "ID", array("Name"));
            $description="";
            $message="";
        }
        $dbHandler->dbDisconnect();
        unset($dbHandler);

?>
    <form method="post">
        <h1><?php echo CREATE_PROJECT_TEXT; ?></h1>
        <?php echo $message ?>
        <?php echo BRANCH_TEXT;?><br />
        <select name="BranchID">
            <?php echo $branches;?>
        </select><br />
        <?php echo PROJECT_NAME_TEXT;?><br />
        <input type="text" name="ProjectName" value="<?php echo $name;?>"/><br />
        <?php echo DESCRIPTION_TEXT; ?><br />
        <textarea name="Description" ><?php echo $description;?></textarea><br />
        <?php if(isset($_GET['id'])&&$_GET['id']!=""){ ?>
        <input type="hidden" name="ID" value="<?php echo $_GET['id']; ?>" />
        <input type="submit" name="Edit" value="<?php echo EDIT_TEXT; ?>" />
        <?php }else{ ?>
        <input type="submit" name="Add" value="<?php echo ADD_TEXT; ?>" />
        <?php }?>
    </form>
<?php
    }
}
elseif(isset($_SESSION['LoggedIn']))
{
    echo NOT_ALLOWED_TO_CREATE_PROJECTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>
