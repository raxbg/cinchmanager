<?php
$systemFiles = array(
"User.php",
"Environment.php",
"dbHandler.php",
"Globals.php"
);
foreach($systemFiles as $file)
require_once($file);
?>