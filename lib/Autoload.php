<?php
function __autoload($className)
{
    require_once ("{HOME_FOLDER_URL}lib/{$className}.php");
}
?>
