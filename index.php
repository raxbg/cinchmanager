<?php
if(is_dir("install") && !file_exists("lib/Globals.php"))
{
    header('Location: install/index.php');
}
require_once("lib/LoadSystem.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title><?php echo COMPANY_NAME;?></title>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" language="javascript" src="js/menu.js"></script>
        <script type="text/javascript" language="javascript" src="js/Ajax.js"></script>
    </head>
    <body>
        <div id="header">
          <?php
            require_once("modules/Languages/languages.php");
          ?>
            <div id="userinfo">
                <?php
                    require_once("modules/UserInfo/UserInfo.php");
                ?>
            </div>
        </div>
        <?php
                require_once("modules/Menu/menu.php");
        ?>
        <div id="page">
            <?php
            if(is_dir("install") && file_exists("lib/Globals.php"))
            {
                echo REMOVE_INSTALL_TEXT;
            }
            elseif(!is_dir("install") && file_exists("lib/Globals.php"))
            {
              if(isset($_POST['submit']) && !isset($_SESSION['LoggedIn']))
              {
                echo INCORRECT_USER_TEXT."<br />";
              }
              elseif(isset($_POST['logout']))
              {
                  echo GOODBYE_TEXT;
              }
              Page::LoadContent();
            }
            ?>
        </div>
    </body>
</html>