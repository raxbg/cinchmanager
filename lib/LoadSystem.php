<?php
require_once("Globals.php");
require_once("Autoload.php");

if(!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started']=true;
}
if(isset($_POST['submit']))
{   
     User::Login($_POST['Email'],$_POST['Password']);
}
User::Remember();
if(isset($_POST['logout']))
{
    User::Logout();             
}
if(isset($_COOKIE['Email']) && !isset($_SESSION['LoggedIn']))
{
    User::AutoLogin();
}
if(isset($_GET['language']))
{
    Environment::SetLanguageCookie($_GET['language']);
}
Environment::SetLanguage();
?>