var opened = false;
var checkPassed = false;
var oldPass;
var newPwd;

function PopUpBox(url)
{
    ClosePopUp();
    var popUpBox = document.createElement("div");
    popUpBox.id = "DialogBox";
    popUpBox.setAttribute("class","PopUpBox");
    popUpBox.innerHTML = "<img src=\"img/close.png\" onClick=\"ClosePopUp()\" title=\"close\" alt=\"close\" class=\"close\"/></br>";
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            popUpBox.innerHTML += xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
    document.getElementById("page").appendChild(popUpBox);
    opened = true;
}
function ClosePopUp()
{
    if(opened)
    {
        var popUp = document.getElementById("DialogBox");
        document.getElementById("page").removeChild(popUp);
        opened = false;
    }
}

function CheckOldPassword(id)
{
    var password = document.getElementById("OldPassword").value;
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            if(xmlhttp.responseText== "true")
            {
                if(checkPassed)
                {
                    document.getElementById("EditBtn").removeAttribute("disabled");
                }
                document.getElementById("Match").style.display="inline";
                document.getElementById("NotMatch").style.display="none";
            }
            else
            {
                document.getElementById("EditBtn").setAttribute("disabled","disabled");
                document.getElementById("NotMatch").style.display="inline";
                document.getElementById("Match").style.display="none";
                checkPassed = false;
            }
        }
      }
    xmlhttp.open("GET","CheckPassword.php?id="+id+"&pass="+password,true);
    xmlhttp.send();
    oldPass = setTimeout("CheckPassword("+id+")",500);
}

function CheckNewPassword()
{
    var newPass = document.getElementById("NewPassword");
    var newPassCheck = document.getElementById("NewPasswordCheck");
    if(newPass.value == newPassCheck.value)
    {
        if(checkPassed)
        {
            document.getElementById("EditBtn").removeAttribute("disabled");
        }
        document.getElementById("NewPassNotMatch").style.display="none";
        document.getElementById("NewPassMatch").style.display="inline";
    }
    else
    {
        document.getElementById("EditBtn").setAttribute("disabled","disabled");
        document.getElementById("NewPassMatch").style.display="none";
        document.getElementById("NewPassNotMatch").style.display="inline";
        checkPassed = false;
    }
    newPwd = setTimeout("CheckNewPassword()",500);
}

function Init(id)
{
    document.getElementById("Match").style.width="100%";
    document.getElementById("NotMatch").style.width="100%";
    document.getElementById("Match").style.display="none";
    document.getElementById("NotMatch").style.display="none";
    document.getElementById("NewPassMatch").style.width="100%";
    document.getElementById("NewPassNotMatch").style.width="100%";
    document.getElementById("NewPassMatch").style.display="none";
    document.getElementById("NewPassNotMatch").style.display="none";
    document.getElementById("OldPassword").focus();
    CheckOldPassword(id);
}

function StopCheck(chk)
{
    if(chk=="oldPwd")
    {
        clearTimeout(oldPass);
    }
    else
    {
        clearTimeout(newPwd);
    }
}