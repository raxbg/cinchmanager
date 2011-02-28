<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] != "n")
{ 
    if(isset($_POST['CreatorID']) && $_POST['Email'] != "" && $_POST['Email'] != NULL)
    {
        $UserIsCreated = User::CreateAccount($_POST['Email'],$_POST['Title'],$_POST['FirstName'],$_POST['SecondName'],
                $_POST['LastName'],$_POST['Gender'],$_POST['Address'],$_POST['Telephone'],$_POST['BranchID'],$_POST['CreatorID'],
                $_POST['EmployeeOrClient'],$_POST['DefaultLanguage']);
        if($_POST['EmployeeOrClient'] == "e" && $UserIsCreated != false)
        {
            $userID = $UserIsCreated;
            $EmployeeIsCreated = User::CreateEmployee($userID, $_POST['PositionID'], $_POST['ManagerID'], $_POST['CanCreateAccounts'], $_POST['CanCreateTB'], $_POST['AssignmentDay']);
            if($EmployeeIsCreated)
            {
                if (Environment::SaveAvatar($userID))
                {
                    echo USER_SUCCESSFULLY_CREATED_TEXT;
                }
                else
                {
                    echo FAILED_TO_SAVE_AVATAR_TEXT;
                }
                echo USER_SUCCESSFULLY_CREATED_TEXT;
            }
        }
        elseif($UserIsCreated)
        {
            $userID = $UserIsCreated;
            if (Environment::SaveAvatar($userID))
            {
                echo USER_SUCCESSFULLY_CREATED_TEXT;
            }
            else
            {
                echo FAILED_TO_SAVE_AVATAR_TEXT;
            }
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
                        ON Employees.UserID = Users.ID";
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $titles = $dbHandler->MakeSelectOptions($titlesQuery, "ID", array("Title"));
        $branches = $dbHandler->MakeSelectOptions($branchesQuery, "ID", array("Name"));
        $positions = $dbHandler->MakeSelectOptions($positionsQuery, "ID", array("Position"));
        $managers = $dbHandler->MakeSelectOptions($managersQuery, "ID", array("FirstName","LastName"));
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        $today = date("Y-m-d");
?>
<script type="text/javascript" src="js/AddEmployees.js"></script>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="CreatorID" value="<?php echo $_SESSION['userinfo']['ID'];?>">
    <h2><?php echo ACCOUNT_INFORMATION_TEXT; ?></h2>
    <?php echo EMAIL_TEXT; ?><br />
    <input type="text" name="Email" id="Email" onfocus="checkEmail()" onblur="setTimeout('stopCheck()',600)"/>
    <span class="PositiveMessage" id="ValidMail"><?php echo VALID_MAIL_TEXT; ?></span>
    <span class="NegativeMessage" id="InvalidMail"><?php echo INVALID_MAIL_TEXT; ?></span>
    <br />
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
    <?php echo AVATAR_TEXT;?><br />
    <input type="file" name="Avatar"><br />
    <?php echo TELEPHONE_TEXT;?><br />
    <input type="text" name="Telephone" /><br />
    <?php echo BRANCH_TEXT;?><br />
    <select name="BranchID">
        <?php echo $branches;?>
    </select><br />
    <?php echo TYPE_TEXT;?><br />
    <select name="EmployeeOrClient" onchange="CheckAccount()" id="EmployeeOrClient">
        <?php
            if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
            {
                echo "<option value=\"e\">".EMPLOYEE_TEXT."</option>";
            }
        ?>
        <option value="c" selected="selected"><?php echo CLIENT_TEXT;?></option>
    </select><br />
    <div id="EmployeeInfo">
        <?php echo POSITION_TEXT;?> <br />
        <select name="PositionID">
            <?php echo $positions; ?>
        </select><br />
        <?php echo MANAGER_TEXT;?><br />
        <select name="ManagerID">
            <option value="none" selected="selected"><?php echo NOBODY_TEXT;?></option>
            <?php echo $managers; ?>
        </select><br />
        <?php echo ACC_CAN_CREATE_TEXT; ?><br />
        <select name="CanCreateAccounts">
            <option value="no">Nobody</option>
            <option value="c">Clients</option>
            <option value="a">All</option>
        </select><br />
        <?php echo ACC_CAN_CREATE_TITLES_TEXT;?><br />
        <select name="CanCreateTB">
            <option value="n">No</option>
            <option value="y">Yes</option>
        </select><br />
        <?php echo ASSIGNMENT_DAY_TEXT;?><br />
        <input type="text" name="AssignmentDay" value="<?php echo $today;?>"/><br />
    </div>
    <?php echo DEFAULT_LANGUAGE_TEXT;?><br />
    <select name="DefaultLanguage">
        <option value="bg">BG</option>
        <option value="en">EN</option>
    </select><br />
    <input type="submit" value="<?php echo CREATE_TEXT;?>" id="AddBtn" disabled="true"/><br />
    <script type="text/javascript">Init();</script>
</form>
<?php
        }
    }
elseif(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] == "n")
{
    echo NOT_ALLOWED_TO_CREATE_ACCOUNTS_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>