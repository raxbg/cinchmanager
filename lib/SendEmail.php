<?php
class SendEmail
{
    public static function SendEmail($email,$message)
    {
        require_once("Globals.php");
        $subject="Welcome to {$GLOBALS['CompanyName']}";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <cinchmanager@system.com>' . "\r\n";
        if($mail)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    public static function NewUserEmail($firstNane,$lastName,$email,$password)
    {
    	return "<html> 
	              <body>
                  This password has been automatically generated: <b>{$password}</b><br>
                  Use this password along with the email to login with your account.
                  Cinch manager provides features connected with the organisation of a project.
                  You can easily set tasks to people or make comments on their work.
                  If you are a client then it is advisable to take a look at our 
                  <a href=\"http://www.google.com\">client tutorial</a> to get known with the basics.
                  </td></tr>
                  </table>
                  Hello {$firstName} {$lastName},
                  An account has ben created for you at <a href='{$_SERVER['SERVER_NAME']}'>{$GLOBALS['CompanyName']}</a><br />
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
																				
                  {$_SERVER['SERVER_NAME']}<br />
                  Powered by CinchManager
	              </body> 
	            </html>";
    }
}
?>
