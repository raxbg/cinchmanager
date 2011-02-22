<?php
class Page
{
    public static function LoadContent()
    {
    	if (isset($_GET['page']))
        {
            if(file_exists(HOME_FOLDER.$_GET['page'].".php"))
            {
                require_once (HOME_FOLDER.$_GET['page'].".php");
            }
            else
            {
                echo PAGE_NOT_FOUND_TEXT;
            }
        }
        else
        {
            echo "Home page";
        }
    }
}
?>
