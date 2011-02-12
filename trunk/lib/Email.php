<?php
class Email
{
    public static function SendEmail($email,$message)
    {
        require_once("Globals.php");
        $subject="Welcome to {$GLOBALS['COMPANY_NAME']}";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: <{$_GLOBALS['SYSTEM_EMAIL']}>" . "\r\n";
        $mailSent = mail($email,$subject,$message,$headers);
        if($mailSent)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    public static function NewUserEmail($firstName,$lastName,$email,$password)
    {
    	return "<html> 
                 <body>
                  Hello {$firstName} {$lastName},
                  An account has ben created for you at <a href='http://{$_SERVER['SERVER_NAME']}'>{$GLOBALS['COMPANY_NAME']}</a><br />
                  <br />
                  <h2>Your account login details:</h2>
									E-mail: {$email}<br/>
									Password: {$password}<br/>
									<br/>
									Your password has been automatically generated, you can easily change it from your account settings.<br/>
									<br/>
									Our management system provides features connected with the organisation of a project.
                  You can easily set tasks, follow the progress and make comments.
                  If you are a client then it is advisable to take a look at our 
                  <a href='http://www.google.com'>client tutorial</a> to get known with the basics.
                  <br />
                  <a href='http://{$_SERVER['SERVER_NAME']}'>{$_SERVER['SERVER_NAME']}</a><br />
                  Powered by CinchManager
	              </body> 
	            </html>";
    }
}
?>
