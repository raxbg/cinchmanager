<?php
namespace System\Environment;

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
}
?>
