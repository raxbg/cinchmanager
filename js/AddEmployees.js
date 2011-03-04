var t;
function CheckAccount()
{
    var acc = document.getElementById("EmployeeOrClient");
    if(acc.value == "e")
    {
        document.getElementById("EmployeeInfo").style.display="block";
    }
    else
    {
        document.getElementById("EmployeeInfo").style.display="none";
    }
}
function checkEmail()
{
    var textField = document.getElementById("Email");
    var pattern = new RegExp("^([A-Za-z0-9_]+@[a-z0-9]+\.[a-z]{2,4})$");
    if(textField.value != "" && pattern.test(textField.value))
    {
        document.getElementById("AddBtn").removeAttribute("disabled");
        document.getElementById("InvalidMail").style.display="none";
        document.getElementById("ValidMail").style.display="inline";
    }
    else
    {
        document.getElementById("AddBtn").setAttribute("disabled","disabled");
        document.getElementById("InvalidMail").style.display="inline";
        document.getElementById("ValidMail").style.display="none"
    }
    t = setTimeout("checkEmail()",500);
}

function stopCheck()
{
    clearTimeout(t);
    document.getElementById("ValidMail").style.display="none";
    document.getElementById("InvalidMail").style.display="none";
}

function Init()
{
    CheckAccount();
    document.getElementById("ValidMail").style.width="100%";
    document.getElementById("InvalidMail").style.width="100%";
    document.getElementById("ValidMail").style.display="none";
    document.getElementById("InvalidMail").style.display="none";
    document.getElementById("Email").focus();
}