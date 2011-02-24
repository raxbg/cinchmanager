var t;
function Edit(oldValue)
{
    document.getElementById("Old").value=oldValue;
    document.getElementById("NewName").value=oldValue;
    document.getElementById("AddBtn").name = "EditTitle";
    document.getElementById("AddBtn").value = editText;
    document.getElementById("EditHeading").style.display="block";
    document.getElementById("AddHeading").style.display="none";
    document.getElementById("AddBtn").removeAttribute("disabled");
}
function CancelEdit()
{
    document.getElementById("Old").value="";
    document.getElementById("NewName").value="";
    document.getElementById("AddBtn").name = "AddTitle";
    document.getElementById("AddBtn").value = addText;
    document.getElementById("EditHeading").style.display="none";
    document.getElementById("AddHeading").style.display="block";
    document.getElementById("AddBtn").setAttribute("disabled","true");
}
function checkBtn()
{
    var textField = document.getElementById("NewName");
    if(textField.value != "")
    {
        document.getElementById("AddBtn").removeAttribute("disabled");
    }
    else
    {
        document.getElementById("AddBtn").setAttribute("disabled","true");
    }
    t = setTimeout("checkBtn()",500);
}
function stopCheck()
{
    setTimeout("clearTimeout(t)",600);
}