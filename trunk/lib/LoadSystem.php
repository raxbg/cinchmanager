<?php
$systemFiles = array(
"User.php",
"dbHandler.php"
);
foreach($systemFiles as $file)
require_once($file);
?>