<?php
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_POST['NewPassword']) && $_POST['NewPassword'] != NULL && $_POST['NewPassword'] != "")
    {
        $message = "";
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id = mysql_real_escape_string($_SESSION['userinfo']['ID']);
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
                if(!$dbHandler->ExecuteQuery("UPDATE Users SET Password='{$newPass}' WHERE ID={$id}"))
                {
                    $message.= "<span class=\"NegativeMessage\">";
                    $message.= FAILED_TO_CHANGE_PASSWORD_TEXT;
                    $message.= "</span>";
                }
                else
                {
                    $message.= "<span class=\"PositiveMessage\">";
                    $message.= PASSWORD_SUCCESSFULLY_CHANGED_TEXT;
                    $message.= "</span>";
                }

            }
            else
            {
                $message.= "<span class=\"NegativeMessage\">";
                $message.= TRYING_TO_CHEAT_TEXT;
                $message.= "</span>";
            }
        }
        else
        {
            $message.= "<span class=\"NegativeMessage\">";
            $message.= TRYING_TO_CHEAT_TEXT;
            $message.= "</span>";
        }
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        echo $message;
    }
    else
    {
        ?>
            <script type="text/javascript" src="js/Ajax.js"></script>
            <form method="post">
                <?php echo ENTER_OLD_PASSWORD_TEXT;?><br/>
                <input type="password" name="OldPassword" id="OldPassword" onfocus="CheckOldPassword(<?php echo $_SESSION['userinfo']['ID'];?>)" onblur="StopCheck('oldPwd')">
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
                Init(<?php echo $_SESSION['userinfo']['ID'];?>);
            </script>
        <?php
    }
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo "<span class=\"NegativeMessage\">";
    echo PLEASE_LOGIN_TEXT;
    echo "</span>";
}
?>
