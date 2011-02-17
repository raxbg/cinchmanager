<?php
$content = 
    "<?php\n".
    "define(\"HOST\", \"{$_POST['Host']}\");\n".
    "define(\"USERNAME\", \"{$_POST['DBUsername']}\");\n".
    "define(\"PASSWORD\", \"{$_POST['DBPassword']}\");\n".
    "define(\"DATABASE\", \"{$_POST['Database']}\");\n".
    "define(\"DEFAULT_LANGUAGE\", \"{$_POST['DefaultLanguage']}\");\n".
		"define(\"COMPANY_NAME\", \"{$_POST['CompanyName']}\");\n".
		"define(\"SYSTEM_EMAIL_ADDRESS\", \"{$_POST['SystemEmail']}\");\n".
		"?>";
$file = fopen("../lib/Globals.php","w") or exit("Unable to create Globals.php!");
fwrite($file,$content);
fclose($file);  
?>