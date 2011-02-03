<?php
$systemFiles = array(
"User.php",
"dbHandler.php",
"Globals.php"
);
foreach($systemFiles as $file)
require_once($file);
?>