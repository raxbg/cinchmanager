<?php
$content = 
    "<?php\n".
    "\$HOST=\"{$_POST['Host']}\";\n".
    "\$USERNAME=\"{$_POST['DBUsername']}\";\n".
    "\$PASSWORD=\"{$_POST['DBPassword']}\";\n".
    "\$DATABASE=\"{$_POST['Database']}\";\n".
    "\$DEFAULT_LANGUAGE = \"{$_POST['DefaultLanguage']}\";\n".
	"\$COMPANY_NAME=\"{$_POST['CompanyName']}\";\n".
	"?>";
$file = fopen("../lib/Globals.php","w") or exit("Unable to create Globals.php!");
fwrite($file,$content);
fclose($file);  
?>