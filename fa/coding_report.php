<!doctype html>
<?php
include "../config/config.php";
$staff_id=verifyAutho();
$v_id=$_REQUEST['q'];
$fy=$_SESSION['fy'];
//echo $fy;
?>
<html>
<head>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<style>
ul li{
width:100%;
margin:0px;
padding:0px;
//border-bottom:solid 5px #ffffff;
}
</style>
<script type="text/javascript">

$(function(){
		$("#reportDate").datepicker({dateFormat :'dd/mm/yy'});
	$("#showReport").click(function(){
		
		var msg='';//alert("msg");
		if($("#reportDate").val()==null || $("#reportDate").val()=='') {
			msg+="Its A mandatory Field Enter Date.\n";
		}
		
		ar1=$("#reportDate").val().split('/');
		//alert($("#reportDate").val());
		ar2=$("#finDate").val().split('-');//alert($("#finDate").val());
		if(ar2[0]>ar1[2] || ar2[1]<ar1[2])
		{
			msg+="Date must be within the Financial Year\n";
		}
		if(msg==''){
			var url3="./report_bck.php?date="+$("#reportDate").val();
			if (window.XMLHttpRequest) 
	 		{xmlhttp=new XMLHttpRequest();}
			else		
	  		{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    		{
				if(xmlhttp.responseText==1){
					$("#loader").hide();
					$("#linkDiv").show();
				}
			}
	  		}	
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();$("#loader").show();
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
	});
	
});
</script>
</head>
<body>

<div id="header" align="center" >
<table align='center' width='60%' bgcolor='silver'>
<tr><th align="center" colspan=1 bgcolor='#F4F4F4'>CODING</th></td>
<tr><td align="center" colspan=1 bgcolor='silver'>Show Report on Date:
<input type="text" value="" id="reportDate" name="reportDate"></td></tr>
<input type="hidden" value="<?php echo $fy;?>" id="finDate" name="finDate"></td></tr>
<td bgcolor='silver' align='right'><input type="button" value="Show" id="showReport" name="showReport"></td></tr>
</table>
</div>
<HR>
<div id="body">
<div id="loader" align="center"  style="display:none">
<img src='../JS/bigrotation2.gif'>
</div>
<div id="linkDiv" style="display:none" >
<table width='70%' align='center' bgcolor='silver' border='0' cellspacing=0 cellpadding=0 >
<tr>

<td>
<!--<ul >
<li><A id="a0" HREF="report.php?value=LA&heading=LIABILITIES" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">10000-LIABILITIES</A></li>
<li><A id="a1" HREF="report.php?value=AS&heading=ASSETS" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">20000-ASSETS</A></li>
<li><A id="a2" HREF="report.php?value=PU&heading=PURCHASE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">30000-PURCHASE</A></li>
<li><A HREF="report.php?value=SA&heading=SALE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=800,height=800'); return false;">40000-SALE</A></li>
<li><A HREF="report.php?value=IN&heading=INCOME" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">50000-INCOME</A></li>
<li><A HREF="report.php?value=EX&heading=EXPENDITURE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=no, top=150,left=350, width=800,height=800'); return false;">60000-EXPENDITURE</A></li>
</ul>
-->
<ul >
<li>10000-LIABILITIES</li>
<li>20000-ASSETS</li>
<li>30000-PURCHASE</li>
<li>40000-SALE</li>
<li>50000-INCOME</li>
<li>60000-EXPENDITURE</li>
</ul>

</td>






<td align='right'>
<!--<ul >
<li><A id="a0" HREF="report.php?value=LA&heading=LIABILITIES" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">10000-LIABILITIES</A></li>
<li><A id="a1" HREF="report.php?value=AS&heading=ASSETS" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">20000-ASSETS</A></li>
<li><A id="a2" HREF="report.php?value=PU&heading=PURCHASE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">30000-PURCHASE</A></li>
<li><A HREF="report.php?value=SA&heading=SALE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=800,height=800'); return false;">40000-SALE</A></li>
<li><A HREF="report.php?value=IN&heading=INCOME" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">50000-INCOME</A></li>
<li><A HREF="report.php?value=EX&heading=EXPENDITURE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=no, top=150,left=350, width=800,height=800'); return false;">60000-EXPENDITURE</A></li>
</ul>
-->
<ul style="list-style:none">
<li><A id="a0" HREF="altCodingPhp.php?gl=10000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">All</A></li>
<li><A id="a1" HREF="altCodingPhp.php?gl=20000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">All</A></li>
<li><A id="a2" HREF="altCodingPhp.php?gl=30000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">All</A></li>
<li><A HREF="altCodingPhp.php?gl=40000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=1000,height=800'); return false;">All</A></li>
<li><A HREF="altCodingPhp.php?gl=50000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">All</A></li>
<li><A HREF="altCodingPhp.php?gl=60000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=no, top=150,left=350, width=1000,height=800'); return false;">All</A></li>
</ul>

</td>







<td>
<!--<ul >
<li><A id="a0" HREF="report.php?value=LA&heading=LIABILITIES" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">10000-LIABILITIES</A></li>
<li><A id="a1" HREF="report.php?value=AS&heading=ASSETS" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">20000-ASSETS</A></li>
<li><A id="a2" HREF="report.php?value=PU&heading=PURCHASE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">30000-PURCHASE</A></li>
<li><A HREF="report.php?value=SA&heading=SALE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=800,height=800'); return false;">40000-SALE</A></li>
<li><A HREF="report.php?value=IN&heading=INCOME" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">50000-INCOME</A></li>
<li><A HREF="report.php?value=EX&heading=EXPENDITURE" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=no, top=150,left=350, width=800,height=800'); return false;">60000-EXPENDITURE</A></li>
</ul>
-->
<ul style="list-style:none">
<li><A id="a0" HREF="codingPhp.php?gl=10000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
<li><A id="a1" HREF="codingPhp.php?gl=20000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
<li><A id="a2" HREF="codingPhp.php?gl=30000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
<li><A HREF="codingPhp.php?gl=40000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
<li><A HREF="codingPhp.php?gl=50000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
<li><A HREF="codingPhp.php?gl=60000" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=no, top=150,left=350, width=1000,height=800'); return false;">Codes Only With Data</A></li>
</ul>

</td>




</tr>
</table>
</div>
</div>

</body>
