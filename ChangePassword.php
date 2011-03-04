<?php
if(isset($_GET['id']) && isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['ID'] == $_GET['id'])
{
    if(isset($_POST['NewPassword']) && $_POST['NewPassword'] != NULL && $_POST['NewPassword'] != "")
    {

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
                <input type="password" name="NewPassword" id="NewPassword"><br/>
                <?php echo ENTER_NEW_PASSWORD_AGAIN_TEXT;?><br/>
                <input type="passwrod" name="NewPasswordCheck" id="NewPasswordCheck" onfocus="CheckNewPassword()" onblur="StopCheck('newPwd')">
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
    echo "Ne mojesh da promenqsh parolite na drugite.";
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo PLEASE_LOGIN_TEXT;
}
elseif(!isset($_GET['id']))
{
    echo "Missing Parameter.";
}
?>
