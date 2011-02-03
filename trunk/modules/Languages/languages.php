<?php
function AddLanguagetoURI($lang)
{	
	$uri=$_SERVER['REQUEST_URI'];
	if (strpos($uri,"?")===false)
	{
		echo $uri."?language=".$lang;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,"language=")===false))
	{
		echo $uri."&language=".$URIstart;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,"language=")!==false))
	{
		$URIstart=substr ($uri ,0,strpos($uri,"language=")+9);
		$URIPartAfterLanguage=substr ($uri ,strpos($uri,"language=")+9);
		if(strpos($URIPartAfterLanguage,"&")!==false)
		{
			$URIend=substr ($URIPartAfterLanguage ,strpos($URIPartAfterLanguage,"&"));
		}
		else
		{
			$URIend="";
		}
		echo $URIstart.$lang.$URIend;
	}
	else
	{
		echo "/";
	}
}
?>
<ul id="languages">
	<li><a href="<?php AddLanguagetoURI("bg"); ?>"><img src="modules/Languages/Flags/bg.png" /></a></li>
	<li><a href="<?php AddLanguagetoURI("en"); ?>"><img src="modules/Languages/Flags/gb.png" /></a></li>
</ul>