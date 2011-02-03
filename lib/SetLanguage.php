<?php
if(isset($_COOKIE['Language']))
{
    if(file_exists("./languages/{$_COOKIE['Language']}.php"))
    {
        $Language = $_COOKIE['Language'];
    }
}
else
{
    $Language = $_DEFAULT_LANGUAGE;
}
require_once("./languages/{$Language}.php");
?>