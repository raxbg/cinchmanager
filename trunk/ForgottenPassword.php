<?php
if(isset($_POST['Email']))
{
    $NewPassword = User::GeneratePassword();
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $NewPasswordEncrypted = $dbHandler->EncryptPwd($NewPassword);
    $email = mysql_real_escape_string($_POST['Email']);
    if(!$dbHandler->ExecuteQuery("UPDATE Users SET Password='{$NewPasswordEncrypted}' WHERE Email='{$email}'"))
    {
        $message = "<span class=\"NegativeMessage\">";
        $message.= FAILED_TO_SET_NEW_PASSWORD_TEXT;
        $message.= "</span>";
    }
    else
    {
        $emailMessage = Email::ForgottenPasswordEmail($email,$NewPassword);
        $subject = "New password for ".COMPANY_NAME;
        $mailSent = Email::SendEmail($email,$emailMessage,$subject);
        if(!$mailSent)
        {
            $message = "<span class=\"NegativeMessage\">";
            $message.= FAILED_TO_SEND_EMAIL_TEXT;
            $message.= "</span>";
        }
        else
        {
            $message = "<span class=\"PositiveMessage\">";
            $message.= NEW_PASSWORD_SENT_TEXT;
            $message.= "</span>";
        }
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);
    echo $message;
}
else
{
?>
<script type="text/javascript" src="js/AddEmployees.js"></script>
<form method="post">
    <input type="text" name="Email" id="Email" onfocus="checkEmail()" onblur="stopCheck()" />
    <span class="PositiveMessage" id="ValidMail"><?php echo VALID_MAIL_TEXT; ?></span>
    <span class="NegativeMessage" id="InvalidMail"><?php echo INVALID_MAIL_TEXT; ?></span>
    <br />
    <input type="submit" name="AddBtn" disabled="disabled" id="AddBtn" value="<?php echo SEND_NEW_PASSWORD_TEXT;?>"/>
</form>
<script type="text/javascript">
    InitForgottenPassword();
</script>
<?php
}
?>
