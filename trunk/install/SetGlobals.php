<?php
$homeURL = $_SERVER['HTTP_REFERER'];
$homeURL = substr($homeURL,0,strpos($homeURL,"install"));
$content = 
    "<?php\n".
    "define(\"HOST\", \"{$_POST['Host']}\");\n".
    "define(\"USERNAME\", \"{$_POST['DBUsername']}\");\n".
    "define(\"PASSWORD\", \"{$_POST['DBPassword']}\");\n".
    "define(\"DATABASE\", \"{$_POST['Database']}\");\n".
    "define(\"DEFAULT_LANGUAGE\", \"{$_POST['DefaultLanguage']}\");\n".
		"define(\"COMPANY_NAME\", \"{$_POST['CompanyName']}\");\n".
		"define(\"SYSTEM_EMAIL_ADDRESS\", \"{$_POST['SystemEmail']}\");\n".
                "define(\"HOME_FOLDER_URL\", \"{$homeURL}\");\n".
		"?>";
$file = fopen("../lib/Globals.php","w") or exit("Unable to create Globals.php!");
fwrite($file,$content);
fclose($file);
?>