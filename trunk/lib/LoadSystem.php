<?php
$systemFiles = array(
"User.php",
"System.php",
"dbHandler.php",
"Globals.php"
);
foreach($systemFiles as $file)
require_once($file);
?>