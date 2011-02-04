<?php
function AddLanguageToURI($language)
{	
	$uri=$_SERVER['REQUEST_URI'];
	if (strpos($uri,"?")===false)
	{
		echo $uri."?language=".$language;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,"language=")===false))
	{
		echo $uri."&language=".$URIStart;
	}
	else if ((strpos($uri,"?")!==false)&&(strpos($uri,"language=")!==false))
	{
		$URIStart=substr ($uri ,0,strpos($uri,"language=")+9);
		$URIPartAfterLanguage=substr ($uri ,strpos($uri,"language=")+9);
		if(strpos($URIPartAfterLanguage,"&")!==false)
		{
			$URIEnd=substr ($URIPartAfterLanguage ,strpos($URIPartAfterLanguage,"&"));
		}
		else
		{
			$URIEnd="";
		}
		echo $URIStart.$language.$URIEnd;
	}
	else
	{
		echo "/";
	}
}
?>
<ul id="languages">
	<li><a href="<?php AddLanguageToURI("bg"); ?>"><img src="modules/Languages/Flags/bg.png" /></a></li>
	<li><a href="<?php AddLanguageToURI("en"); ?>"><img src="modules/Languages/Flags/gb.png" /></a></li>
</ul>