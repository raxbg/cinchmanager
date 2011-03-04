<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']) && isset($_GET['id']) && ($_SESSION['userinfo']['ID'] == $_GET['id']))
{
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $id = mysql_real_escape_string($_GET['id']);
    $pass = mysql_real_escape_string($_GET['pass']);
    $result = $dbHandler->ExecuteQuery("SELECT Password From Users WHERE ID={$id}");
    $realPassword = mysql_fetch_row($result);
    $realPassword = $realPassword[0];
    $enteredPassword = $dbHandler->EncryptPwd($pass);
    $dbHandler->dbDisconnect();
    unset($dbHandler);
    if($enteredPassword == $realPassword)
    {
        echo "true";
    }
    else
    {
        echo "false";
    }

}
elseif(isset($_SESSION['LoggedIn']) && isset($_GET['id']) && ($_SESSION['userinfo']['ID'] != $_GET['id']))
{
    echo CANNOT_CHANGE_OTHERS_PASSOWRDS_TEXT;
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo PLEASE_LOGIN_TEXT;
}
elseif(!isset($_GET['id']) || !isset($_GET['pass']))
{
    echo MISSING_PARAMETER;
}

?>
