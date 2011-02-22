<?php
require_once ("Globals.php");
function __autoload($className)
{
    require_once (HOME_FOLDER."lib/{$className}.php");
}
?>
