var xmlhttp
//for depreciation
//asset opening
function showHintop(str){
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
//if(str=="ln"){document.getElementById("type_of_ln").disabled=false;}
//else{document.getElementById("type_of_ln").disabled=true;}
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
//var s_type=document.getElementById("type_of").value;
var url="loading_op.php";
//url=url+"?q="+str+"&s_type="+s_type;
url=url+"?q="+str;
//alert(url)
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
//
//
//-----------------------------
function show_hint_member(str)
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

var url="search_by_name.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}

//================================================================================

function showHint_loan(str){
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
var url="loan_configuration.php";
url=url+"?q="+str+"&s=1";
//alert(url)
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


//==========================================PAYROLL===============================

function showHint_subemp(str){
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

var url="emp_name.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}
//===================================================
function showHint_grant(str)
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

var url="adhoc_report.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}


function showHint_grantemp(str)
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

var url="adhoc_report_emp.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}
//====================================================
function showHint_subemp_pf(str){
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

var url="emp_name_pf.php";

url=url+"?q="+str;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}
//=========================================
function showHint_subemp_pfid(str){
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

var url="pf_loan_dt.php";

url=url+"?q="+str+"&ei=1&mn=2";
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.send(null);
}
//==========================================
function showHint_subemp_pfyr(str1){
//alert("alert"+str1);
if (str1.length==0)
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

var url="pf_loan_dt.php";

url=url+"?yr="+str1+"&mn=2";
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedwd;
xmlhttp.send(null);
}

//==========================================
function showHint_subemp_pfmm(str2){
//alert("alert"+str2);
if (str2.length==0)
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

var url="pf_loan_dt.php";

url=url+"?mth="+str2+"&mn=2";
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedmm;
xmlhttp.send(null);
}
//================month working days========
function showHint_wd(str,yr){
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

var url="ead.php";

url=url+"?q="+str+"&wd=1&yr="+yr;
//alert(url);
url=url+"&sid="+Math.random();
//xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.onreadystatechange=stateChangedwd;
xmlhttp.send(null);
}

//===================statechange fro working days================
function stateChangedwd()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("textHint").innerHTML=xmlhttp.responseText;
 //alert("hi");
  }

}
//=============================================================================
function stateChangedmm()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("ttHint").innerHTML=xmlhttp.responseText;
 //alert("hi");
  }

}

//============================================

function showHint(str){
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
//if(str=="ln"){document.getElementById("type_of_ln").disabled=false;}
//else{document.getElementById("type_of_ln").disabled=true;}
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
//var s_type=document.getElementById("type_of").value;
var url="loading.php";
//url=url+"?q="+str+"&s_type="+s_type;
url=url+"?q="+str;
//alert(url)
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
//state change function
function stateChanged()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
  
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
