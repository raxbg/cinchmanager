<?php
if(isset($_COOKIE['Language']))
{
    $Language = $_COOKIE['Language'];
}
else
{
    $Language = "en";
}
$systemFiles = array(
"User.php",
"dbHandler.php",
"./languages/{$Language}.php"
);
foreach($systemFiles as $file)
require_once($file);
?>