var timeout	= 500;
var level_2Timeout	= 0;
var level_2	= 0;
var level_3Timeout	= 0;
var level_3	= 0;

function openLevel_2(id)
{	
	cancelLevel_2Timeout();
	closeLevel_2();	
	level_2 = document.getElementById(id);
	level_2.style.visibility = 'visible';
}

function closeLevel_2()
{
	if(level_2)
	{
		level_2.style.visibility = 'hidden';
		level_2 = null;
		closeLevel_3();
	}
}

function closeLevel_2AfterTime()
{
	level_2Timeout = window.setTimeout(closeLevel_2, timeout);
}

function cancelLevel_2Timeout()
{
	if(level_2Timeout)
	{
		window.clearTimeout(level_2Timeout);
		level_2Timeout = null;
	}
}
function openLevel_3(id)
{	
	cancelLevel_3Timeout();
	cancelLevel_2Timeout();
	closeLevel_3()	
	level_3 = document.getElementById(id);
	level_3.style.visibility = 'visible';
}

function closeLevel_3()
{
	if(level_3)
	{
		level_3.style.visibility = 'hidden';
		level_3 = null;
	}
}

function closeLevel_3AfterTime()
{
	level_3Timeout = window.setTimeout(closeLevel_3, timeout);
}

function cancelLevel_3Timeout()
{
	if(level_3Timeout)
	{
		window.clearTimeout(level_3Timeout);
		level_3Timeout = null;
	}
}
document.onclick = closeLevel_2; 