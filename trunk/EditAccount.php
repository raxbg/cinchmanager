<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['CanCreateAccounts'] != "n")
{
    if(isset($_POST['Edit']) && $_POST['Email'] != "" && $_POST['Email'] != NULL)
    {
        $message = "";
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();

        $email = mysql_real_escape_string($_POST['Email']);
        $title = mysql_real_escape_string($_POST['Title']);
        $firstName = mysql_real_escape_string($_POST['FirstName']);
        $secondName = mysql_real_escape_string($_POST['SecondName']);
        $lastName = mysql_real_escape_string($_POST['LastName']);
        $gender = mysql_real_escape_string($_POST['Gender']);
        $address = mysql_real_escape_string($_POST['Address']);
        $telephone = mysql_real_escape_string($_POST['Telephone']);
        $branchID = mysql_real_escape_string($_POST['BranchID']);
        $employeeOrClient = mysql_real_escape_string($_POST['EmployeeOrClient']);
        $language = mysql_real_escape_string($_POST['DefaultLanguage']);
        $userID = mysql_real_escape_string($_POST['UserID']);

        $updateAccount = "UPDATE Users
            SET Email='{$email}', TitleID='{$title}', FirstName='{$firstName}', SecondName='{$secondName}', LastName='{$lastName}',
            Gender='{$gender}', Address='{$address}', Telephone='{$telephone}', BranchID='{$branchID}',
            EmployeeOrClient='{$employeeOrClient}', Language='{$language}'
            WHERE ID='{$userID}'";
        $accountIsUpdated = $dbHandler->ExecuteQuery($updateAccount);

        if($_POST['EmployeeOrClient'] == "e" && $accountIsUpdated)
        {
            $positionID = mysql_real_escape_string($_POST['PositionID']);
            $canCreateAccounts = mysql_real_escape_string($_POST['CanCreateAccounts']);
            $isAdmin = mysql_real_escape_string($_POST['IsAdmin']);
            $assignmentDay = mysql_real_escape_string($_POST['AssignmentDay']);
            $managerID = mysql_real_escape_string($_POST['ManagerID']);

            $updateEmployee = "UPDATE Employees
                SET PositionID='{$positionID}', CanCreateAccounts='{$canCreateAccounts}',
                IsAdmin='{$isAdmin}', AssignmentDay='{$assignmentDay}' 
                WHERE UserID='{$userID}'";
            $EmployeeIsUpdated = $dbHandler->ExecuteQuery($updateEmployee);
            $ManagerIsSet = false;
            if($EmployeeIsUpdated)
            {
                $dbHandler->dbDisconnect();
                $ManagerIsSet = Hierarchy::MoveInHierarchy($userID, $managerID);
                $dbHandler->dbConnect();
            }

            if($EmployeeIsUpdated && $ManagerIsSet)
            {
                $message.= "<span class=\"PositiveMessage\">";
                $message.= EMPLOYEE_SUCCESSFULLY_UPDATED_TEXT;
                $message.= "</span>";
                $AvatarIsUpdated = Environment::SaveAvatar($userID);
                if(!is_null($_FILES['Avatar']['name']) && $_FILES['Avatar']['name'] != "" && !$AvatarIsUpdated)
                {
                    $message.= "<span class=\"NegativeMessage\">";
                    $message.= FAILED_TO_SAVE_AVATAR_TEXT;
                    $message.= "</span>";
                }
            }
            elseif($EmployeeIsUpdated && !$ManagerIsSet)
            {
                $message.= "<span class=\"PositiveMessage\">";
                $message.= EMPLOYEE_SUCCESSFULLY_UPDATED_TEXT;
                $message.= "</span>";
                $message.= "<span class=\"NegativeMessage\">";
                $message.= FAILED_TO_SET_MANAGER_TEXT;
                $message.= "</span>";
            }
            else
            {
                $message.= "<span class=\"NegativeMessage\">";
                $message.= FAILED_TO_UPDATE_EMPLOYEE_TEXT;
                $message.= "</span>";
            }
                
        }
        elseif($accountIsUpdated)
        {
            $dbHandler->dbDisconnect();
            $message.= "<span class=\"PositiveMessage\">";
            $message.= USER_SUCCESSFULLY_UPDATED_TEXT;
            $message.= "</span>";
            $AvatarIsUpdated = Environment::SaveAvatar($userID);
            if(!is_null($_FILES['Avatar']['name']) && $_FILES['Avatar']['name'] != "" && !$AvatarIsUpdated)
            {
                $message.= "<span class=\"NegativeMessage\">";
                $message.= FAILED_TO_SAVE_AVATAR_TEXT;
                $message.= "</span>";
            }
        }
        else
        {
            $dbHandler->dbDisconnect();
            $message.= "<span class=\"NegativeMessage\">";
            $message.= FAILED_TO_UPDATE_USER_TEXT;
            $message.= "</span>";
        }
        echo $message;
    }
    else
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id=mysql_real_escape_string($_GET['id']);
        $titlesQuery = "SELECT * FROM Titles";
        $branchesQuery = "SELECT ID,Name FROM Branches";
        $positionsQuery = "SELECT * FROM Positions";
        $managersQuery = "SELECT Users.ID,Users.FirstName,Users.LastName
                        FROM Employees
                        LEFT JOIN Users
                        ON Employees.UserID = Users.ID";
        $userinfoQuery = "SELECT Users.*,
                        Titles.Title,
                        Employees.*
                        FROM Users
                        LEFT JOIN Titles
                        ON Users.TitleID = Titles.ID
                        LEFT JOIN Employees ON Users.ID = Employees.UserID
                        WHERE Users.ID = '{$id}'";

        $userinfo = $dbHandler->ExecuteQuery($userinfoQuery);
        $userinfo = mysql_fetch_array($userinfo);
        $titles = $dbHandler->MakeSelectOptions($titlesQuery, "ID", array("Title"),$userinfo['TitleID']);
        $branches = $dbHandler->MakeSelectOptions($branchesQuery, "ID", array("Name"),$userinfo['BranchID']);
        $positions = $dbHandler->MakeSelectOptions($positionsQuery, "ID", array("Position"),$userinfo['PositionID']);
        $managers = $dbHandler->MakeSelectOptions($managersQuery, "ID", array("FirstName","LastName"),$userinfo['ManagerID']);
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        $today = date("Y-m-d");
?>
<script type="text/javascript" src="js/AddEmployees.js"></script>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="Edit">
    <input type="hidden" name="UserID" value="<?php echo $_GET['id'];?>">
    <h2><?php echo ACCOUNT_INFORMATION_TEXT; ?></h2>
    <?php echo EMAIL_TEXT; ?><br />
    <input type="text" name="Email" value="<?php echo $userinfo['Email'];?>" id="Email" onfocus="checkEmail()" onblur="setTimeout('stopCheck()',600)"/>
    <span class="PositiveMessage" id="ValidMail"><?php echo VALID_MAIL_TEXT; ?></span>
    <span class="NegativeMessage" id="InvalidMail"><?php echo INVALID_MAIL_TEXT; ?></span>
    <br />
    <?php echo TITLE_TEXT;?><br />
    <select name="Title">
        <?php echo $titles; ?>
    </select><br />
    <?php echo FIRST_NAME_TEXT;?><br />
    <input type="text" value="<?php echo $userinfo['FirstName'];?>" name="FirstName" /><br />
    <?php echo SECOND_NAME_TEXT;?><br />
    <input type="text" value="<?php echo $userinfo['SecondName'];?>" name="SecondName" /><br />
    <?php echo LAST_NAME_TEXT;?><br />
    <input type="text" value="<?php echo $userinfo['LastName'];?>" name="LastName" /><br />
    <?php echo GENDER_TEXT;?><br />
    <input type="radio" name="Gender" value="m" <?php if($userinfo['Gender'] == "m") echo "checked=\"checked\"";?>>
    <?php echo MALE_TEXT;?>
    <input type="radio" name="Gender" value="f" <?php if($userinfo['Gender'] == "f") echo "checked=\"checked\"";?>>
    <?php echo FEMALE_TEXT;?>
    <br />
    <?php echo AVATAR_TEXT;?><br />
    <input type="file" name="Avatar"><br />
    <?php echo TELEPHONE_TEXT;?><br />
    <input type="text" value="<?php echo $userinfo['Telephone'];?>" name="Telephone" /><br />
    <?php echo BRANCH_TEXT;?><br />
    <select name="BranchID">
        <?php echo $branches;?>
    </select><br />
    <?php echo TYPE_TEXT;?><br />
    <select name="EmployeeOrClient" onchange="CheckAccount()" id="EmployeeOrClient">
        <?php
            if($_SESSION['userinfo']['CanCreateAccounts'] == "a")
            {
                echo "<option value=\"e\"";
                if($userinfo['EmployeeOrClient'] == "e") echo " selected=\"selected\"";
                echo ">".EMPLOYEE_TEXT."</option>";
            }
        ?>
        <option value="c" <?php if($userinfo['EmployeeOrClient'] == "c") echo "selected=\"selected\""?>><?php echo CLIENT_TEXT;?></option>
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
        <input type="radio" name="CanCreateAccounts" value="n" <?php if($userinfo['CanCreateAccounts'] == "n") echo "checked=\"checked\""?>><?php echo NOBODY_TEXT;?>
        <input type="radio" name="CanCreateAccounts" value="c" <?php if($userinfo['CanCreateAccounts'] == "c") echo "checked=\"checked\""?>><?php echo CLIENTS_TEXT;?>
        <input type="radio" name="CanCreateAccounts" value="a" <?php if($userinfo['CanCreateAccounts'] == "a") echo "checked=\"checked\""?>><?php echo ALL_TEXT;?><br />
        <?php echo ACC_CAN_CREATE_TITLES_TEXT;?><br />
        <input type="radio" name="IsAdmin" value="1" <?php if($userinfo['IsAdmin'] == "1") echo "checked=\"checked\""?>><?php echo YES_TEXT;?>
        <input type="radio" name="IsAdmin" value="0" <?php if($userinfo['IsAdmin'] == "0") echo "checked=\"checked\""?>><?php echo NO_TEXT;?><br />
        <?php echo ASSIGNMENT_DAY_TEXT;?><br />
        <input type="text" value="<?php echo $userinfo['AssignmentDay'];?>" name="AssignmentDay" /><br />
    </div>
    <?php echo DEFAULT_LANGUAGE_TEXT;?><br />
    <select name="DefaultLanguage">
        <option value="bg" <?php if($userinfo['Language'] == "bg") echo "selected=\"selected\""?>>BG</option>
        <option value="en" <?php if($userinfo['Language'] == "en") echo "selected=\"selected\""?>>EN</option>
    </select><br />
    <input type="submit" value="<?php echo EDIT_TEXT;?>" id="AddBtn" disabled="true"/><br />
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
