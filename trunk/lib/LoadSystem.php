<?php
$systemFiles = array(
"User.php",
"dbHandler.php",
"Globals.php",
"System.php"
);
foreach($systemFiles as $file)
require_once($file);
?>