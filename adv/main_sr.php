<?php
include "../config/config.php";
?>
<HTML>
<HEAD>
<SCRIPT type="text/javascript">
function search_name(str){
//alert (str);
if(str.length==0) str='%';
//alert (str)
var url="main.php?name="+str;
//alert(url);
if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			document.getElementById("hintSpan").innerHTML=xmlhttp.responseText;
			document.getElementById("sub").disabled=true;
			
		}
						}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}
</SCRIPT>
</HEAD>
<BODY onload='search_name("%");' bgcolor='#4D4D4D'>
<div width=100% align=center style="background-color:#D4D4D4;height:30px;padding-top:10px;" valign="center">
Search By Name : 
<input type=text name=search_n id=search_n <?echo $HIGHLIGHT;?>onkeyup='search_name(this.value);'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='tran.php'><font color=black>New Entry</a>
</div>
<br>
<span id='hintSpan'></span>
</BODY>
</HTML>
