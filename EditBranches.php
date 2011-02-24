<?php
if(isset($_SESSION['LoggedIn']) && User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();
    if(isset($_POST['Add']))
    {
        if($_POST['NewBranchName'] != NULL && $_POST['NewBranchName'] != ""&&
                $_POST['NewBranchAddress'] != NULL && $_POST['NewBranchAddress'] != "")
        {
            $query = "INSERT INTO Branches (Name, Address) VALUES (\"{$_POST['NewBranchName']}\",\"{$_POST['NewBranchAddress']}\")";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".BRANCH_ADDED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    elseif(isset($_POST['Edit']))
    {
        if($_POST['NewBranchName'] != NULL && $_POST['NewBranchName'] != ""&&
                $_POST['NewBranchAddress'] != NULL && $_POST['NewBranchAddress'] != "")
        {
            $query = "UPDATE Branches SET Name=\"{$_POST['NewBranchName']}\", Address=\"{$_POST['NewBranchAddress']}\" WHERE ID=\"{$_SESSION['BranchID']}\"";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".BRANCH_UPDATED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    elseif (isset($_SESSION["BranchID"]))
    {
        echo $_SESSION["BranchID"];
echo EDIT_BRANCH;
?>
<form method="post">
    <?php echo BRANCH_TEXT ?><br />
    <input type="text" name="NewBranchName" /><br />
    <?php echo ADDRESS_TEXT ?><br />
    <textarea name="NewBranchAddress"></textarea><br />
    <?php echo TELEPHONE_TEXT ?><br />
    <input type="text" name="BranchTelephone" /><br />
    <input type="submit" name="Edit" value="<?php echo EDIT_TEXT ?>">
</form>
<?php
    }
    else
    {
echo ADD_NEW_BRANCH_TEXT
?>
<form method="post">
    <?php echo BRANCH_TEXT ?><br />
    <input type="text" name="NewBranchName" /><br />
    <?php echo ADDRESS_TEXT ?><br />
    <textarea name="NewBranchAddress"></textarea><br />
    <?php echo TELEPHONE_TEXT ?><br />
    <input type="text" name="BranchTelephone" /><br />
    <input type="submit" name="Add" value="<?php echo ADD_TEXT ?>">
</form>
<?php
    }
    echo $message;
}
elseif(isset($_SESSION['LoggedIn']) && !User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    echo NOT_ALLOWED_TO_CREATE_ACCOUNTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>