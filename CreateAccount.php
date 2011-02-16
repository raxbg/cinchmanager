<?php
if(isset($_SESSION['userinfo']) && User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{ 
    if(isset($_POST['CreatorID']))
    {
        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$_POST['SecondName'],
                $_POST['LastName'],$_POST['Gender'],$_POST['Address'],$_POST['BranchID'],$_POST['CreatorID'],
                $_POST['EmployeeOrClient'],$_POST['DefaultLanguage']);
        if($UserIsCreated)
        {
            echo "User successfully created. The password was send to the given email.";
        }
        else
        {
            echo "Failed to create user. Unknown reason...";
        }
    }
    else
    {
?>
<form method="post">
    <input type="hidden" name="CreatorID" value="<?php echo $_SESSION['userinfo']['ID'];?>">
    <input type="hidden" name="BranchID" value="<?php echo $_SESSION['userinfo']['BranchID'];?>">
    <h2>Account information</h2>
    Email:<br />
    <input type="text" name="Email" /><br />
    Title:<br />
    <select name="Title">
        <option value="1">Mr.</option>
        <option value="2">Mrs.</option>
    </select><br />
    First name:<br />
    <input type="text" name="FirstName" /><br />
    Second name:<br />
    <input type="text" name="SecondName" /><br />
    Last name:<br />
    <input type="text" name="LastName" /><br />
    Gender:<br />
    <select name="Gender">
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select><br />
    Address:<br />
    <textarea name="Address"></textarea><br />
    Telephone:<br />
    <input type="text" name="Telephone" /><br />
    Type:<br />
    <?php
        if(!is_null($_SESSION['userinfo']['CanCreateAccounts']))
        {
    ?>
    <select name="EmployeeOrClient">
        <?php
            if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
            {
                echo "<option value=\"e\">Employee</option>";
            }
        ?>
        <option value="c">Client</option>
    </select><br />
    <?php
        }
    ?>
    Default language:<br />
    <select name="DefaultLanguage">
        <option value="bg">BG</option>
        <option value="en">EN</option>
    </select><br />
    <?php
    if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
    {
    ?>
    Account can create:<br />
    <select name="CanCreateAccounts">
        <option value="null">none</option>
        <option value="a">Everything</option>
        <option value="c">Only clients</option>
    </select><br />
    <?php
    }
    ?>
    <input type="submit" value="Create"/><br />
</form>
<?php
        }
    }
elseif(isset($_SESSION['userinfo']) && !User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{
    echo "You are not allowed to create new user accounts!";
}
else
{
    echo "Please login first!";
}
?>
</div>
