var xmlhttp
var status

function setFocus(str)
{
 status=str;
 document.getElementById("txt1").focus();
}
function showHint(str)
{
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="mini_gethint.php"; //arijit
//var url="search_mini_usage_menu.php";//arijit
//url=url+"?q="+str+"&status="+status;arijit
url=url+"?q="+str+"&op=display";//arijit

url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.open("GET",url,true);
//xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.send(null);
}
//function to search mini wise
function showHintMini(str)
{
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="mini_gethint.php"; //arijit
//var url="search_mini_usage_menu.php";//arijit
//url=url+"?q="+str+"&status="+status;arijit
url=url+"?mini_name="+str+"&op=display";//arijit
//alert(url);
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.open("GET",url,true);
//xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.send(null);
}
//function to search farmer wise
function showHintFarmer(str)
{
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="farmer_gethint.php"; //arijit
//var url="search_mini_usage_menu.php";//arijit
//url=url+"?q="+str+"&status="+status;arijit
url=url+"?q="+str+"&op=display";//arijit
url=url+"&sid="+Math.random();
//alert(url);
xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;//arijit
xmlhttp.send(null);
}
//state change function
function stateChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("txtHint").innerHTML=xmlhttp.responseText;//arijit
  //document.getElementById("cust_n").value= encodeURIComponent(document.getElementById("name").value);//arijit
  }
}
//browser define function
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
