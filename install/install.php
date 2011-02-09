<?php
    $connectionInfo = 
        "<?php\n".
        "class dbHandler\n".
        "{\n".
        "\tprivate \$host=\"{$_POST['Database']}\";\n".
        "\tprivate \$username=\"{$_POST['DBUsername']}\";\n".
        "\tprivate \$password=\"{$_POST['DBPassword']}\";\n".
        "\tprivate \$con;\n".
        "\tprivate \$db=\"{$_POST['Database']}\";\n\n";    
    
    $file = fopen("../lib/dbHandler.php","r") or exit("Unable to open file!");
    $line = 0;
    $content="";
    while(!feof($file))
    {
        if($line >=3)
        {
            $content.=fgets($file);
            $line++;
        }
        else
        {
            fgets($file);
            $line++;
        }
    }
    fclose($file);
    $file = fopen("../lib/dbHandler.php","w") or exit("Unable to open file!");
    fwrite($file,$connectionInfo);
    fwrite($file,$content);
    fclose($file);
    require_once("../lib/dbHandler.php");
    require_once("../lib/User.php");
    require_once("mainDBCreator.php");
?>
