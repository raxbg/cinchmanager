<?php
$systemFiles = array(
"User.php",
"dbHandler.php",
"../languages/en.php"
);
foreach($systemFiles as $file)
require_once($file);
?>