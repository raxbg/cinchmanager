<?php
class Environment
{
    public static function SetGetVariable($name,$value)
    {    
        $uri=$_SERVER['REQUEST_URI'];
        if (strpos($uri,"?")===false)
        {
            return $uri."?".$name."=".$value;
        }
        else if ((strpos($uri,"?")!==false)&&(strpos($uri,$name."=")===false))
        {
            return $uri."&".$name."=".$value;
        }
        else if ((strpos($uri,"?")!==false)&&(strpos($uri,$name."=")!==false))
        {
            $URIStart=substr ($uri ,0,strpos($uri,$name."=")+strlen($name)+1);
            $URIPartAfterVarName=substr ($uri ,strpos($uri,$name."=")+strlen($name)+1);
            if(strpos($URIPartAfterVarName,"&")!==false)
            {
                $URIEnd=substr ($URIPartAfterVarName ,strpos($URIPartAfterVarName,"&"));
            }
            else
            {
                $URIEnd="";
            }
            return $URIStart.$value.$URIEnd;
        }
        else
        {
            return "/";
        }
    }
    
    public static function SetLanguageCookie($language)
    {
        if(file_exists("./languages/{$language}.php"))
        {
            setcookie("Language","",time()-3600);   
            setcookie("Language",$language,time()+3600*24*365);
            $_COOKIE['Language'] = $language;
        }
    }
    
    public static function SetLanguage()
    {
        if(isset($_COOKIE['Language']))
        {
            if(file_exists("./languages/{$_COOKIE['Language']}.php"))
            {
                $Language = $_COOKIE['Language'];
            }
        }
        else
        {
            $Language = $GLOBALS['DEFAULT_LANGUAGE'];;
        }
        require_once("./languages/{$Language}.php");
    }
    
    public static function EmailPassword($email,$password)
    {
        require_once("Globals.php");
        $subject="Welcome to {$GLOBALS['CompanyName']}";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <cinchmanager@system.com>' . "\r\n";
        $message= 
            "<html> 
              <body>
                <center> 
                    <table cellspacing=\"0\" cellpadding=\"0\" border=\"1px\" style=\"width:400px;border-color:#DEDEDE;\">
                    <tr><td style=\"width:398px;height:50px;background-color:E3E3E3;\">
                    <h2>Cinch Manager - {$GLOBALS['CompanyName']}</h2>
                    </td></tr>
                    <tr><td style=\"width:398px;\">
                    This password has been automatically generated: <b>{$password}</b><br>
                    Use this password along with the email to login with your account.
                    Cinch manager provides features connected with the organisation of a project.
                    You can easily set tasks to people or make comments on their work.
                    If you are a client then it is advisable to take a look at our 
                    <a href=\"http://www.google.com\">client tutorial</a> to get known with the basics.
                    </td></tr>
                    </table>
                </center> 
              </body> 
            </html>"; 
        $mail=mail($email,$subject,$message,$headers);
        if($mail)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}
?>
