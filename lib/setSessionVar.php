<?php
$varName = $_GET['varName'];
$value = $_GET['value'];
$_SESSION["{$varName}"] = $value;
echo $varName." ";
echo $value." ";
echo $_SESSION["BranchID"];
?>
