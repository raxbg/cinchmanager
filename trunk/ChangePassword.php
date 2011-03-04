<?php
if(isset($_GET['id']) && isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['ID'] == $_GET['id'])
{
    if(isset($_POST['NewPassword']) && $_POST['NewPassword'] != NULL && $_POST['NewPassword'] != "")
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id = mysql_real_escape_string($_GET['id']);
        $pass = mysql_real_escape_string($_POST['OldPassword']);
        $result = $dbHandler->ExecuteQuery("SELECT Password From Users WHERE ID={$id}");
        $realPassword = mysql_fetch_row($result);
        $realPassword = $realPassword[0];
        $enteredPassword = $dbHandler->EncryptPwd($pass);
        if($enteredPassword == $realPassword)
        {
            if($_POST['NewPassword'] == $_POST['NewPasswordCheck'] && $_POST['NewPassword'] != "" && !is_null($_POST['NewPassword']))
            {
                $newPass = mysql_real_escape_string($_POST['NewPassword']);
                $newPass = $dbHandler->EncryptPwd($newPass);
                $dbHandler->ExecuteQuery("UPDATE Users SET Password={$newPass} WHERE ID={$id}");
            }
            else
            {
                echo TRYING_TO_CHEAT_TEXT;
            }
        }

        else
        {
            echo TRYING_TO_CHEAT_TEXT;
        }
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        ?>
            <script type="text/javascript" src="js/Ajax.js"></script>
            <form method="post">
                <?php echo ENTER_OLD_PASSWORD_TEXT;?><br/>
                <input type="password" name="OldPassword" id="OldPassword" onfocus="CheckOldPassword(<?php echo $_GET['id'];?>)" onblur="StopCheck('oldPwd')">
                <span class="PositiveMessage" id="Match"><?php echo PASSWORD_MATCH_TEXT; ?></span>
                <span class="NegativeMessage" id="NotMatch"><?php echo PASSWORD_NOT_MATCH_TEXT; ?></span>
                <br />
                <?php echo ENTER_NEW_PASSWORD_TEXT;?><br/>
                <input type="password" name="NewPassword" id="NewPassword" onfocus="CheckNewPassword()" onblur="StopCheck('newPwd')"><br/>
                <?php echo ENTER_NEW_PASSWORD_AGAIN_TEXT;?><br/>
                <input type="password" name="NewPasswordCheck" id="NewPasswordCheck" onfocus="CheckNewPassword()" onblur="StopCheck('newPwd')">
                <span class="PositiveMessage" id="NewPassMatch"><?php echo PASSWORD_MATCH_TEXT; ?></span>
                <span class="NegativeMessage" id="NewPassNotMatch"><?php echo PASSWORD_NOT_MATCH_TEXT; ?></span>
                <br />
                <input type="submit" value="<?php echo EDIT_TEXT;?>" id="EditBtn">
            </form>
            <script type="text/javascript">
                Init(<?php echo $_GET['id'];?>);
            </script>
        <?php
    }
}
elseif(isset($_GET['id']) && isset($_SESSION['LoggedIn']) && !$_SESSION['userinfo']['ID'] != $_GET['id'])
{
    echo CANNOT_CHANGE_OTHERS_PASSOWRDS_TEXT;
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo PLEASE_LOGIN_TEXT;
}
elseif(!isset($_GET['id']))
{
    echo MISSING_PARAMETER;
}
?>
