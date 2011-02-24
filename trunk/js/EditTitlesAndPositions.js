var t;
function Edit(oldValue)
{
    document.getElementById("Old").value=oldValue;
    document.getElementById("NewName").value=oldValue;
    document.getElementById("AddBtn").name = "Edit";
    document.getElementById("AddBtn").value = editText;
    document.getElementById("EditHeading").style.display="block";
    document.getElementById("AddHeading").style.display="none";
    document.getElementById("cancelBtn").style.display="inline";
    document.getElementById("AddBtn").removeAttribute("disabled");
}
function CancelEdit()
{
    document.getElementById("Old").value="";
    document.getElementById("NewName").value="";
    document.getElementById("AddBtn").name = "Add";
    document.getElementById("AddBtn").value = addText;
    document.getElementById("EditHeading").style.display="none";
    document.getElementById("AddHeading").style.display="block";
    document.getElementById("cancelBtn").style.display="none";
    document.getElementById("AddBtn").setAttribute("disabled","true");
}
function checkField()
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
    t = setTimeout("checkField()",500);
}
function stopCheck()
{
    setTimeout("clearTimeout(t)",600);
}