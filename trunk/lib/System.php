<?php
function SetLanguage($language)
{
    if(file_exists("./languages/{$language}.php"))
    {
        setcookie("Language","",time()-3600);   
        setcookie("Language",$language,time()+3600*24*365);
        $_COOKIE['Language'] = $language;
    }
}
?>
