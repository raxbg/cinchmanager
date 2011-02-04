<?php
class System
{
    public static function SetLanguage($language)
    {
        if(file_exists("./languages/{$language}.php"))
        {
            setcookie("Language","",time()-3600);   
            setcookie("Language",$language,time()+3600*24*365);
            $_COOKIE['Language'] = $language;
        }
    }

    public static function SetGetVariable($name,$value)
    {    
        $uri=$_SERVER['REQUEST_URI'];
        if (strpos($uri,"?")===false)
        {
            echo $uri."?".$name."=".$value;
        }
        else if ((strpos($uri,"?")!==false)&&(strpos($uri,$name."=")===false))
        {
            echo $uri."&".$name."=".$value;
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
            echo $URIStart.$value.$URIEnd;
        }
        else
        {
            echo "/";
        }
    }
}
?>
