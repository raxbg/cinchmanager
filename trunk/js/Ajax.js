function PopUpBox(url)
{
    var popUpBox = document.createElement("div");
    popUpBox.id = "DialogBox";
    popUpBox.setAttribute("class","PopUpBox");
    popUpBox.innerHTML = "<button onClick=\"ClosePopUp(\'"+popUpBox.id+"\')\">Close</button></br>";
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
}
function ClosePopUp(id)
{
    var popUp = document.getElementById(id);
    document.getElementById("page").removeChild(popUp);
}