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
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        }
    else
    {

        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        if(isset($_POST['Add']))
        {
            $branches = $dbHandler->MakeSelectOptions("SELECT ID,Name FROM Branches", "ID", array("Name"),$_POST['BranchID']);
            $description=$_POST['Description'];
            $message = "<span class=\"NegativeMessage\">".ENTER_PROJECT_NAME_TEXT."</span>";
        }
        else
        {
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
        <input type="text" name="ProjectName" /><br />
        <?php echo DESCRIPTION_TEXT; ?><br />
        <textarea name="Description" ><?php echo $description;?></textarea><br />
        <input type="submit" name="Add" value="<?php echo ADD_TEXT; ?>">
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
