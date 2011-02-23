function Edit(oldValue)
{
    document.getElementById("Old").value=oldValue;
    document.getElementById("NewName").value=oldValue;
    document.getElementById("EditBtn").style.display="inline";
    document.getElementById("AddBtn").style.display="none";
    document.getElementById("EditHeading").style.display="block";
    document.getElementById("AddHeading").style.display="none";
}