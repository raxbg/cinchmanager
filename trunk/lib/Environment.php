<?php
require_once("Autoload.php");

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
        if(file_exists(HOME_FOLDER."languages/{$language}.php"))
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
            if(file_exists(HOME_FOLDER."languages/{$_COOKIE['Language']}.php"))
            {
                $LanguageFile = HOME_FOLDER."languages/{$_COOKIE['Language']}.php";
            }
        }
        else
        {
            if(file_exists(HOME_FOLDER."languages/".DEFAULT_LANGUAGE.".php"))
            {
                $LanguageFile = HOME_FOLDER."languages/".DEFAULT_LANGUAGE.".php";
            }
        }
        require_once($LanguageFile);
    }

    public static function SaveAvatar($userID)
    {
        if(is_null($_FILES['Avatar']['name']) || $_FILES['Avatar']['name'] == "")
        {
            return false;
        }
        else
        {
            $filename = $_FILES['Avatar']['tmp_name'];
            $fileExtension = substr(strrchr($_FILES['Avatar']['name'],"."),1);

            list($width, $height) = getimagesize($filename);
            if ($width>120)
            {
                    $percent = $width/120;
            }
            else
            {
                    $percent = 1;
            }
            $new_width = $width / $percent;
            $new_height = $height / $percent;

            $image_p = imagecreatetruecolor($new_width, $new_height);
            switch ($fileExtension)
            {
                case "jpg":
                    $image = imagecreatefromjpeg($filename);
                    break;
                case "jpeg":
                    $image = imagecreatefromjpeg($filename);
                    break;
                case "png":
                    $image = imagecreatefrompng($filename);
                    break;
                case "gif":
                    $image = imagecreatefromgif($filename);
                    break;
                default:
                    return false;
            }
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $filename = HOME_FOLDER."avatars/user_{$userID}.jpg";
            imagejpeg($image_p,$filename,100);
            return true;
        }
    }
}
?>
