<?php
if(isset($_COOKIE['Language']))
{
    $Language = $_COOKIE['Language'];
}
else
{
    $Language = $_DEFAULT_LANGUAGE;
}
require_once("./languages/{$Language}.php");
?>