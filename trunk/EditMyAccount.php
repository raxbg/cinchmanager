<?php
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_POST['Edit']))
    {
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
        $language = mysql_real_escape_string($_POST['DefaultLanguage']);

        $query = "UPDATE Users
                SET Email='{$email}', TitleID='{$title}', FirstName='{$firstName}', SecondName='{$secondName}', LastName='{$lastName}',
                Gender='{$gender}', Address='{$address}', Telephone='{$telephone}', Language='{$language}'
                WHERE ID={$_SESSION['userinfo']['ID']}";
        if(!$dbHandler->ExecuteQuery($query))
        {
            $message = "<span class=\"NegativeMessage\">";
            $message.= FAILED_TO_UPDATE_ACCOUNT_TEXT;
            $message.= "</span>";
        }
        else
        {
            $message = "<span class=\"PositiveMessage\">";
            $message.= ACCOUNT_SUCCESSFULLY_UPDATED_TEXT;
            $message.= "</span>";
            $AvatarIsUpdated = Environment::SaveAvatar($_POST['userinfo']['ID']);
            if(!is_null($_FILES['Avatar']['name']) && $_FILES['Avatar']['name'] != "" && !$AvatarIsUpdated)
            {
                $message.= "<span class=\"NegativeMessage\">";
                $message.= FAILED_TO_SAVE_AVATAR_TEXT;
                $message.= "</span>";
            }
        }
        echo $message;
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $titlesQuery = "SELECT * FROM Titles";
        $userinfo = $_SESSION['userinfo'];
        $titles = $dbHandler->MakeSelectOptions($titlesQuery, "ID", array("Title"),$userinfo['TitleID']);
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    ?>
    <script type="text/javascript" src="js/AddEmployees.js"></script>
    <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="Edit">
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
            <?php echo ADDRESS_TEXT;?><br />
            <input type="text" value="<?php echo $userinfo['Address'];?>" name="Address" /><br />
            <?php echo DEFAULT_LANGUAGE_TEXT;?><br />
            <select name="DefaultLanguage">
                <option value="bg" <?php if($userinfo['Language'] == "bg") echo "selected=\"selected\""?>>BG</option>
                <option value="en" <?php if($userinfo['Language'] == "en") echo "selected=\"selected\""?>>EN</option>
            </select><br />
            <input type="submit" value="<?php echo EDIT_TEXT;?>" id="AddBtn" disabled="true"/><br />
            <script type="text/javascript">
                checkEmail();
            </script>
        </form>
    <?php
    }
}
else
{
    echo "<span class=\"NegativeMessage\">";
    echo PLEASE_LOGIN_TEXT;
    echo "</span>";
}

?>
