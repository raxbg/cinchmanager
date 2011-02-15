<?php
$content = 
    "<?php\n".
    "\const HOST= \"{$_POST['Host']}\";\n".
    "\const USERNAME = \"{$_POST['DBUsername']}\";\n".
    "\const PASSWORD = \"{$_POST['DBPassword']}\";\n".
    "\const DATABASE = \"{$_POST['Database']}\";\n".
    "\const DEFAULT_LANGUAGE = \"{$_POST['DefaultLanguage']}\";\n".
	"\const COMPANY_NAME = \"{$_POST['CompanyName']}\";\n".
	"?>";
$file = fopen("../lib/Globals.php","w") or exit("Unable to create Globals.php!");
fwrite($file,$content);
fclose($file);  
?>