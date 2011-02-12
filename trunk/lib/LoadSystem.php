<?php
$systemFiles = array(
"Globals.php",
"Environment.php",
"dbHandler.php",
"User.php",
"SendEmail.php"
);
foreach($systemFiles as $file)
{
    require_once($file);
}

if(!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started']=true;
}
if(isset($_POST['submit_button']))
{   
     User::Login($_POST['Email'],$_POST['Password']);
}
User::Remember();
if(isset($_POST['logout']))
{
    User::Logout();             
}
if(isset($_COOKIE['Email']))
{
    User::AutoLogin();
}
if(isset($_GET['language']))
{
    Environment::SetLanguageCookie($_GET['language']);
}
Environment::SetLanguage();
?>