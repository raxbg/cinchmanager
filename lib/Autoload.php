<?php
function __autoload($className)
{
    if(file_exists("{$className}.php"))
    {
        require_once ("{$className}.php");
    }
    else
    {
        require_once ("../lib/{$className}.php");
    }
}
?>
