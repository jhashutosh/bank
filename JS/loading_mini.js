var xmlhttp

function showHint_customer(str)
{
//alert("alert"+str);
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

var url="cust_land_crop_dtl.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}

function showHint_land(str,mini)
{
//alert("alert"+str+"mini"+mini);
if (str.length==0)
  {
  document.getElementById("textHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="cust_land_crop_dtl.php";

url=url+"?l="+str+"&mini="+mini;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedland;
xmlhttp.send(null);
}

//
function showcrop(str,c_id)
{
//alert("alert"+str);
if (str.length==0)
  {
  document.getElementById("textHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="cust_crop_dtls.php";

url=url+"?s="+str+"&c_id="+c_id;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedland;
xmlhttp.send(null);
}

//

function showHint_area(str,id)
{
//alert("alert"+str);
if (str.length==0)
  {
  document.getElementById("ttHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="cust_land_crop_dtl.php";

url=url+"?a="+str+"&l="+id;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedarea;
xmlhttp.send(null);
}


function showHint_crop(str)
{
//alert("alert"+str);
if (str.length==0)
  {
  document.getElementById("tHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="cust_land_crop_dtl.php";

url=url+"?c="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedcrop;
xmlhttp.send(null);
}

function showseason(str)
{
//alert("alert"+str);
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

var url="crop_master_tan.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}



//===================================================state change function =======================================================
function stateChanged()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
  
  }
}

//==========================================================================
function stateChangedland()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("textHint").innerHTML=xmlhttp.responseText;
 //alert("hi");
  }

}
//=============================================================================
function stateChangedarea()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("ttHint").innerHTML=xmlhttp.responseText;
 //alert("hi");
  }

}


function stateChangedcrop()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("tHint").innerHTML=xmlhttp.responseText;
 //alert("hi");
  }

}



//===================================================browser define function===================================================
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

