var opened = false;
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