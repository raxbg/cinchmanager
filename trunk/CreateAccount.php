<?php
if(isset($_SESSION['LoggedIn']) && User::CanCreateAccounts($_SESSION['userinfo']['CanCreateAccounts']))
{ 
    if(isset($_POST['CreatorID']))
    {
        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$_POST['SecondName'],
                $_POST['LastName'],$_POST['Gender'],$_POST['Address'],$_POST['Telephone'],$_POST['BranchID'],$_POST['CreatorID'],
                $_POST['EmployeeOrClient'],$_POST['DefaultLanguage']);
        if($UserIsCreated)
        {
            echo USER_SUCCESSFULLY_CREATED_TEXT;
        }
        else
        {
            echo FAILED_TO_CREATE_USER_TEXT;
        }
    }
    else
    {
        $titlesQuery = "SELECT * FROM Titles";
        $branchesQuery = "SELECT ID,Name FROM Branches";
        $positionsQuery = "SELECT * FROM Positions";
        $managersQuery = "SELECT Users.ID,Users.FirstName,Users.LastName
                        FROM Employees
                        LEFT JOIN Users
                        ON Employeed.UserID = Users.ID";
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $positions = $dbHandler->MakeSelectOptions($positionsQuery, "ID", array("Position"));
?>
<form method="post">
    <input type="hidden" name="CreatorID" value="<?php echo $_SESSION['userinfo']['ID'];?>">
    <h2><?php echo ACCOUNT_INFORMATION_TEXT; ?></h2>
    <?php echo Email; ?><br />
    <input type="text" name="Email" /><br />
    <?php echo TITLE_TEXT;?><br />
    <select name="Title">
        <?php echo $titles; ?>
    </select><br />
    <?php echo FIRST_NAME_TEXT;?><br />
    <input type="text" name="FirstName" /><br />
    <?php echo SECOND_NAME_TEXT;?><br />
    <input type="text" name="SecondName" /><br />
    <?php echo LAST_NAME_TEXT;?><br />
    <input type="text" name="LastName" /><br />
    <?php echo GENDER_TEXT;?><br />
    <input type="radio" name="Gender" value="m"><?php echo MALE_TEXT;?>
    <input type="radio" name="Gender" value="f"><?php echo FEMALE_TEXT;?>
    <br />
    <?php echo BRANCH_TEXT;?><br />
    <textarea name="Address"></textarea><br />
    <?php echo TELEPHONE_TEXT;?><br />
    <input type="text" name="Telephone" /><br />
    <?php echo BRANCH_TEXT;?><br />
    <select name="BranchID">
        <?php echo $branches;?>
    </select><br />
    <?php echo TYPE_TEXT;?><br />
    <select name="EmployeeOrClient">
        <?php
            if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
            {
                echo "<option value=\"e\">".EMPLOYEE_TEXT."</option>";
            }
        ?>
        <option value="c"><?php echo CLIENT_TEXT;?></option>
    </select><br />
    <div id="EmployeeInfo">
        Position:<br />
        <select name="Position">
            <?php echo $positions; ?>
        </select><br />
        Manager:<br />
        <select name="Manager">
            <?php echo $managers; ?>
        </select><br />
        Employee can create accounts for:<br />
        <select name="CanCreateAccounts">
            <option value="no">Nobody</option>
            <option value="c">Clients</option>
            <option value="a">All</option>
        </select><br />
        Employee can create/edit titles,positions and branches:<br />
        <select name="CanCreateAccounts">
            <option value="n">No</option>
            <option value="y">Yes</option>
        </select><br />
        Assignment date:<br />
        <input type="text" name="AssignmentDate" /><br />
    </div>
    <?php echo DEFAULT_LANGUAGE_TEXT;?><br />
    <select name="DefaultLanguage">
        <option value="bg">BG</option>
        <option value="en">EN</option>
    </select><br />
    <?php
    if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
    {
    ?>
    <?php echo ACC_CAN_CREATE_TEXT;?><br />
    <select name="CanCreateAccounts">
        <option value="null"><?php echo NONE_TEXT;?></option>
        <option value="a"><?php echo EVERYTHING_TEXT;?></option>
        <option value="c"><?php echo ONLY_CLIENTS_TEXT;?></option>
    </select><br />
    <?php
    }
    ?>
    <input type="submit" value="<?php echo CREATE_TEXT;?>"/><br />
</form>
<?php
        }
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