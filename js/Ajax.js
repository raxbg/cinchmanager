var opened = false;
var checkOldPassed = false;
var checkNewPassed = false;
var files = 1;
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
                if(checkOldPassed && checkNewPassed)
                {
                    document.getElementById("EditBtn").removeAttribute("disabled");
                }
                document.getElementById("Match").style.display="inline";
                document.getElementById("NotMatch").style.display="none";
                checkOldPassed = true;
            }
            else
            {
                document.getElementById("EditBtn").setAttribute("disabled","disabled");
                document.getElementById("NotMatch").style.display="inline";
                document.getElementById("Match").style.display="none";
                checkOldPassed = false;
            }
        }
      }
    xmlhttp.open("GET","CheckPassword.php?id="+id+"&pass="+password,true);
    xmlhttp.send();
    oldPass = setTimeout("CheckOldPassword("+id+")",500);
}

function CheckNewPassword()
{
    var newPass = document.getElementById("NewPassword");
    var newPassCheck = document.getElementById("NewPasswordCheck");
    if(newPass.value == newPassCheck.value)
    {
        if(checkOldPassed && checkNewPassed)
        {
            document.getElementById("EditBtn").removeAttribute("disabled");
        }
        document.getElementById("NewPassNotMatch").style.display="none";
        document.getElementById("NewPassMatch").style.display="inline";
        checkNewPassed = true;
    }
    else
    {
        document.getElementById("EditBtn").setAttribute("disabled","disabled");
        document.getElementById("NewPassMatch").style.display="none";
        document.getElementById("NewPassNotMatch").style.display="inline";
        checkNewPassed = false;
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

function FillMembers()
{
    var id = document.getElementById("ProjectID").value;
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
            document.getElementById("ProjectMembers").innerHTML = xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","GetProjectMembers.php?id="+id,true);
    xmlhttp.send();
}

function UploadMore()
{
    var elementName = "Attachment"+(files+1);
    files++;
    var newFile = document.createElement("input");
    newFile.setAttribute("type","file");
    newFile.setAttribute("name",elementName);
    document.getElementById("NewAttachments").appendChild(newFile);
}

function changeStatus(amount)
{
    document.TaskStatus.src="img/"+amount+"percent.png";
    document.getElementById("PercentText").innerHTML = amount;
    document.getElementById("NewStatus").value = amount;
}

function revertStatus(img,status)
{
    document.TaskStatus.src=img;
    document.getElementById("PercentText").innerHTML = status;
    document.getElementById("NewStatus").value = status;
}

function setStatus(id)
{
    var newStatus = document.getElementById("NewStatus").value;
    var taskID = document.getElementById("TaskID").value;
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
            LoadStatus(id);
        }
      }
    xmlhttp.open("POST","index.php?page=Tasks",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("EditTaskStatus=true&NewStatus="+newStatus+"&TaskID="+taskID);
}

function AttachFiles(id)
{
    var newStatus = document.getElementById("NewStatus").value;
    var taskID = document.getElementById("TaskID").value;
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
            LoadAttachments(id);
        }
      }
    xmlhttp.open("POST","Attachments.php?id="+id,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("Attach=true&NewStatus="+newStatus+"&TaskID="+taskID);
}

function LoadStatus(id)
{
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
            if(document.getElementById("StatusOrAttachments") != null)
            {
                document.getElementById("StatusOrAttachments").innerHTML = xmlhttp.responseText;
            }
            else
            {
                setTimeout("LoadStatus(id)",500);
            }
        }
      }
    xmlhttp.open("GET","ChangeTaskStatus.php?id="+id,true);
    xmlhttp.send();
}

function LoadAttachments(id)
{
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
            if(document.getElementById("StatusOrAttachments") != null)
            {
                document.getElementById("StatusOrAttachments").innerHTML = xmlhttp.responseText;
            }
            else
            {
                setTimeout("LoadAttachments(id)",500);
            }
        }
      }
    xmlhttp.open("GET","Attachments.php?id="+id,true);
    xmlhttp.send();
}