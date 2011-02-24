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
window.onload = CheckAccount();

