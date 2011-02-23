function Edit(oldValue)
{
    document.getElementById("Old").value=oldValue;
    document.getElementById("NewName").value=oldValue;
    document.getElementById("AddBtn").name = "EditTitle";
    document.getElementById("AddBtn").value = editText;
    document.getElementById("EditHeading").style.display="block";
    document.getElementById("AddHeading").style.display="none";
    document.getElementById("CancelBtn").style.display="inline";
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
    document.getElementById("CancelBtn").style.display="none";
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
    setTimeout("checkBtn()",500);
}