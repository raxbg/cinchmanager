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
            $query = "INSERT INTO Branches (Name, Address, Telephone) VALUES (\"{$_POST['NewBranchName']}\",\"{$_POST['NewBranchAddress']}\",\"{$_POST['BranchTelephone']}\")";
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
            $query = "UPDATE Branches SET Name=\"{$_POST['NewBranchName']}\", Address=\"{$_POST['NewBranchAddress']}\", Telephone=\"{$_POST['BranchTelephone']}\" WHERE ID=\"{$_POST['id']}\"";
            $dbHandler->ExecuteQuery($query);
            $message = "<span class=\"PositiveMessage\">".BRANCH_UPDATED_TEXT."</span>";
        }
        else
        {
            $message = "<span class=\"NegativeMessage\">".INVALID_VALUE_TEXT."</span>";
        }
    }
    
    if (isset($_GET['id']))
    {
        echo EDIT_BRANCH_TEXT;
        $id=mysql_real_escape_string($_GET['id']);
        $query = "SELECT * FROM Branches WHERE ID={$id}";
        $result = $dbHandler->ExecuteQuery($query);
        $branch = mysql_fetch_array($result);
        $branchName = $branch['Name'];
        $address = $branch['Address'];
        $telephone = $branch['Telephone'];
    }
    else
    {
        echo ADD_NEW_BRANCH_TEXT;
        $id="";
        $branchName = "";
        $address = "";
        $telephone = "";
    }
    
    echo $message;
?>
    <form method="post" action="index.php?page=EditBranches">
        <?php echo BRANCH_TEXT ?><br />
        <input type="text" name="NewBranchName" value="<?php echo $branchName ?>" /><br />
        <?php echo ADDRESS_TEXT ?><br />
        <textarea name="NewBranchAddress"><?php echo $address ?></textarea><br />
        <?php echo TELEPHONE_TEXT ?><br />
        <input type="text" name="BranchTelephone" value="<?php echo $telephone ?>"/><br />
        <?php 
        if (isset($_GET['id']))
        {
        ?>
        <input type="hidden" name="id"  value="<?php echo $id ?>" />
        <input type="submit" name="Edit" value="<?php echo EDIT_TEXT ?>">
        <?php
        }
        else
        {
        ?>
        <input type="submit" name="Add" value="<?php echo ADD_TEXT ?>">
        <?php
        }
        ?>
    </form>

<?php
}
elseif(isset($_SESSION['LoggedIn']) && !User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    echo NOT_ALLOWED_TO_CREATE_BRANCHES_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>