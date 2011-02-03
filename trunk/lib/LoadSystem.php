<?php
$systemFiles = array(
"User.php",
"dbHandler.php",
"./languages/bg.php"
);
foreach($systemFiles as $file)
require_once($file);
?>