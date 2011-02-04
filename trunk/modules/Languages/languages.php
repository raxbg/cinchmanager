<?php
function SetGetVariable($name,$value)
{	
	$uri=$_SERVER['REQUEST_URI'];
	if (strpos($uri,"?")===false)
	{
		echo $uri."?".$name."=".$value;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,$name."=")===false))
	{
		echo $uri."&".$name."=".$value;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,$name."=")!==false))
	{
		$URIStart=substr ($uri ,0,strpos($uri,$name."=")+strlen($name)+1);
		$URIPartAfterVarName=substr ($uri ,strpos($uri,$name."=")+strlen($name)+1);
		if(strpos($URIPartAfterVarName,"&")!==false)
		{
			$URIEnd=substr ($URIPartAfterVarName ,strpos($URIPartAfterVarName,"&"));
		}
		else
		{
			$URIEnd="";
		}
		echo $URIStart.$value.$URIEnd;
	}
	else
	{
		echo "/";
	}
}
?>
<ul id="languages">
	<li><a href="<?php SetGetVariable("language","bg"); ?>"><img src="modules/Languages/Flags/bg.png" /></a></li>
	<li><a href="<?php SetGetVariable("language","en"); ?>"><img src="modules/Languages/Flags/gb.png" /></a></li>
</ul>